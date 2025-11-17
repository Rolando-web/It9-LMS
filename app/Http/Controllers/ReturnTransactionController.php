<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\BookTransaction;
use App\Models\ActivityLog;

class ReturnTransactionController extends Controller
{
  // User requests a return
  public function request(Request $request, $id)
  {
    $user = Auth::user();
    if (!$user) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    $tx = BookTransaction::where('id', $id)->where('user_id', $user->id)->firstOrFail();

    if (in_array($tx->status, ['returned', 'return_pending', 'damaged'])) {
      return response()->json(['message' => 'Return already processed or pending'], 422);
    }

    $due = $tx->due_date ? \Carbon\Carbon::parse($tx->due_date) : null;
    $returned = \Carbon\Carbon::now();
    $daysOver = 0;
    if ($due && $returned->greaterThan($due)) {
      $daysOver = $due->copy()->startOfDay()->diffInDays($returned->copy()->startOfDay());
    }

    $fee = max(0, $daysOver * 50);

    $tx->return_requested_at = now();
    $tx->days_overdue = $daysOver;
    $tx->fee = $fee;
    $tx->original_fee = $fee;
    $tx->status = 'return_pending';
    $tx->save();

    $book = Book::find($tx->book_id);

    ActivityLog::create([
      'user_id' => $user->id,
      'user_name' => $user->firstName . ' ' . $user->lastName,
      'role' => $user->role,
      'action' => 'Request Return',
      'details' => 'Requested return for book: ' . ($book ? $book->title : $tx->book_id),
      'status' => 'success',
    ]);

    \App\Http\Controllers\NotificationController::returnRequestToAdmins(
      $tx->id,
      $book ? $book->title : 'Book',
      $user->firstName . ' ' . $user->lastName
    );

    $message = 'Return request submitted. Please wait for admin approval.';
    if ($fee > 0) {
      $message .= ' Total overdue fee: ₱' . number_format($fee, 2);
    }

    return response()->json([
      'message' => $message,
      'transaction' => $tx,
      'fee' => $fee,
      'days_overdue' => $daysOver,
      'book_title' => $book ? $book->title : 'Unknown Book'
    ]);
  }

  // Admin approves a return request
  public function approve(Request $request, $id)
  {
    $user = Auth::user();
    if (!$user || !in_array($user->role, ['admin', 'super_admin'])) {
      return response()->json(['message' => 'Unauthorized'], 403);
    }

    $tx = BookTransaction::with('book')->findOrFail($id);

    if ($tx->status !== 'return_pending') {
      return response()->json(['message' => 'Not a pending return request'], 422);
    }

    // Use frozen overdue metrics and fee 
    $now = now();
    $existingFee = is_null($tx->fee) ? 0 : (float)$tx->fee; 

    // If frozen fee wasn't stored properly
    if ($existingFee <= 0) {
      if (!is_null($tx->days_overdue) && $tx->days_overdue > 0) {
        $existingFee = $tx->days_overdue * 50;
      } elseif ($tx->return_requested_at && $tx->due_date) {
        $reqDay = \Carbon\Carbon::parse($tx->return_requested_at)->startOfDay();
        $dueDay = \Carbon\Carbon::parse($tx->due_date)->startOfDay();
        $frozenDays = $reqDay->greaterThan($dueDay) ? $dueDay->diffInDays($reqDay) : 0;
        $existingFee = $frozenDays * 50;
        if (is_null($tx->days_overdue)) {
          $tx->days_overdue = $frozenDays;
        }
      } else {
        $dueDay = $tx->due_date ? \Carbon\Carbon::parse($tx->due_date)->startOfDay() : null;
        $today = $dueDay ? now()->startOfDay() : null;
        $liveDays = ($dueDay && $today && $today->greaterThan($dueDay)) ? $dueDay->diffInDays($today) : 0;
        $existingFee = $liveDays * 50;
        if (is_null($tx->days_overdue)) {
          $tx->days_overdue = $liveDays;
        }
      }
    }

    $tx->fee = max(0, $existingFee);
    $tx->original_fee = max(0, $existingFee);
    // days_overdue 
    if (is_null($tx->days_overdue)) {
      $tx->days_overdue = 0;
    }
    $tx->returned_at = $now;
    $tx->status = $tx->days_overdue > 0 ? 'overdue' : 'returned';
    $tx->return_approved_by = $user->id;
    $tx->save();
    // Increment book copies
    $book = Book::find($tx->book_id);
    if ($book) {
      $book->increment('copies');
    }

    ActivityLog::create([
      'user_id' => $user->id,
      'user_name' => $user->firstName . ' ' . $user->lastName,
      'role' => $user->role,
      'action' => 'Approve Return',
      'details' => 'Approved return for transaction: ' . $tx->id . ' | Days overdue: ' . ($tx->days_overdue ?? 0) . ' | Fee: ' . ($tx->fee ?? 0),
      'status' => 'success',
    ]);

    \App\Http\Controllers\NotificationController::returnApproved(
      $tx->user_id,
      $tx->id,
      optional($tx->book)->title ?? 'Book',
      (float) ($tx->fee ?? 0),
      (int) ($tx->days_overdue ?? 0)
    );

    return response()->json(['message' => 'Return approved', 'transaction' => $tx]);
  }

  // Admin rejects a return request 
  public function reject(Request $request, $id)
  {
    $user = Auth::user();
    if (!$user || !in_array($user->role, ['admin', 'super_admin'])) {
      return response()->json(['message' => 'Unauthorized'], 403);
    }

    $request->validate([
      'reason' => 'required|string|max:500',
      'damage_fee' => 'required|numeric|min:0',
    ]);

    $tx = BookTransaction::with('book')->findOrFail($id);

    if ($tx->status !== 'return_pending') {
      return response()->json(['message' => 'Not a pending return request'], 422);
    }

    $reason = $request->input('reason');
    $damageFee = (float) $request->input('damage_fee');

    // Do NOT escalate overdue after request
    $now = now();
    $existingFee = is_null($tx->fee) ? 0 : (float)$tx->fee;

    // If frozen overdue fee wasn't captured
    if ($existingFee <= 0) {
      if (!is_null($tx->days_overdue) && $tx->days_overdue > 0) {
        $existingFee = $tx->days_overdue * 50;
      } elseif ($tx->return_requested_at && $tx->due_date) {
        $reqDay = \Carbon\Carbon::parse($tx->return_requested_at)->startOfDay();
        $dueDay = \Carbon\Carbon::parse($tx->due_date)->startOfDay();
        $frozenDays = $reqDay->greaterThan($dueDay) ? $dueDay->diffInDays($reqDay) : 0;
        $existingFee = $frozenDays * 50;
        $tx->days_overdue = $frozenDays;
      } else {
        $dueDay = $tx->due_date ? \Carbon\Carbon::parse($tx->due_date)->startOfDay() : null;
        $today = now()->startOfDay();
        $liveDays = ($dueDay && $today->greaterThan($dueDay)) ? $dueDay->diffInDays($today) : 0;
        $existingFee = $liveDays * 50;
        $tx->days_overdue = $liveDays;
      }
    }

    $tx->returned_at = $now;
    $tx->status = 'damaged';
    $tx->fee = $existingFee + $damageFee;
    $tx->original_fee = $existingFee + $damageFee;
    $tx->return_approved_by = $user->id;
    $tx->save();

    $book = Book::find($tx->book_id);
    if ($book) {
      $book->increment('copies');
    }

    ActivityLog::create([
      'user_id' => $user->id,
      'user_name' => $user->firstName . ' ' . $user->lastName,
      'role' => $user->role,
      'action' => 'Reject Return (Damaged)',
      'details' => 'Rejected return for transaction: ' . $tx->id . ' | Reason: ' . $reason . ' | Days overdue: ' . ($tx->days_overdue ?? 0) . ' | Total Fee: ₱' . number_format($tx->fee, 2) . ' (includes ₱' . number_format($damageFee, 2) . ' damage fee)',
      'status' => 'success',
    ]);
    $overdueFeeBeforeDamage = $existingFee;
    \App\Http\Controllers\NotificationController::returnRejectedDamaged(
      $tx->user_id,
      $tx->id,
      optional($tx->book)->title ?? 'Book',
      $reason,
      (float) $tx->fee,
      (float) $overdueFeeBeforeDamage,
      (float) $damageFee
    );

    return response()->json(['message' => 'Return rejected - damage fee applied', 'transaction' => $tx]);
  }
}
