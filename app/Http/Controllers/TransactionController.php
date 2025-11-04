<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\BookTransaction;
use App\Models\ActivityLog;
use App\Models\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
  // Store a borrow transaction
  public function borrow(Request $request)
  {
    $request->validate([
      'book_id' => 'required|exists:books,id',
      'duration' => 'required|integer|min:1',
      'due_date' => 'required|date',
    ]);

    $user = Auth::user();
    if (!$user) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    $book = Book::findOrFail($request->book_id);

    // Check if user already has this book borrowed (pending, borrowed, or overdue)
    $alreadyBorrowed = BookTransaction::where('user_id', $user->id)
      ->where('book_id', $book->id)
      ->whereIn('status', ['pending', 'borrowed', 'overdue'])
      ->exists();

    if ($alreadyBorrowed) {
      return response()->json(['message' => 'You have already borrowed this book'], 422);
    }

    if ($book->copies <= 0) {
      return response()->json(['message' => 'No copies available'], 422);
    }

    // create transaction
    $tx = BookTransaction::create([
      'user_id' => $user->id,
      'book_id' => $book->id,
      'borrowed_at' => now(),
      'due_date' => $request->due_date,
      // create as pending — staff must approve to mark as borrowed
      'status' => 'pending',
    ]);

    // NOTE: do not decrement book copies yet — admin approval will decrement copies when status becomes 'borrowed'

    // log activity
    ActivityLog::create([
      'user_id' => $user->id,
      'user_name' => $user->firstName . ' ' . $user->lastName,
      'role' => $user->role,
      'action' => 'Borrow Book',
      'details' => 'Borrowed book: ' . $book->title,
      'status' => 'success',
    ]);

    return response()->json(['message' => 'Borrow request submitted', 'transaction' => $tx], 201);
  }

  // Return a borrowed book
  public function return(Request $request, $id)
  {
    $user = Auth::user();
    if (!$user) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    $tx = BookTransaction::where('id', $id)->where('user_id', $user->id)->firstOrFail();

    if ($tx->status === 'returned') {
      return response()->json(['message' => 'Already returned'], 422);
    }

    $tx->returned_at = now();

    // compute overdue
    $due = \Carbon\Carbon::parse($tx->due_date);
    $returned = \Carbon\Carbon::now();
    $daysOver = max(0, $returned->startOfDay()->diffInDays($due->startOfDay()));
    if ($returned->greaterThan($due)) {
      $daysOver = $returned->startOfDay()->diffInDays($due->startOfDay());
    } else {
      $daysOver = 0;
    }

    $fee = $daysOver * 50;

    $tx->days_overdue = $daysOver;
    $tx->fee = $fee;
    $tx->status = $daysOver > 0 ? 'overdue' : 'returned';
    $tx->save();

    $book = Book::find($tx->book_id);
    if ($book) $book->increment('copies');

    ActivityLog::create([
      'user_id' => $user->id,
      'user_name' => $user->firstName . ' ' . $user->lastName,
      'role' => $user->role,
      'action' => 'Return Book',
      'details' => 'Returned book: ' . ($book ? $book->title : $tx->book_id) . ' | Fee: ' . $fee,
      'status' => 'success',
    ]);

    return response()->json(['message' => 'Book returned', 'fee' => $fee, 'transaction' => $tx]);
  }

  // Admin approves a pending transaction
  public function adminApprove(Request $request, $id)
  {
    $user = Auth::user();
    if (!$user || !in_array($user->role, ['admin', 'super_admin'])) {
      return response()->json(['message' => 'Unauthorized'], 403);
    }

    $tx = BookTransaction::with('book')->findOrFail($id);

    if ($tx->status === 'approved' || $tx->status === 'borrowed') {
      return response()->json(['message' => 'Already approved'], 422);
    }
    if (!$tx->borrowed_at) $tx->borrowed_at = now();
    $book = Book::find($tx->book_id);
    if ($book && $book->copies > 0) {
      $book->decrement('copies');
    }

    $tx->status = 'borrowed';
    $tx->save();

    ActivityLog::create([
      'user_id' => $user->id,
      'user_name' => $user->firstName . ' ' . $user->lastName,
      'role' => $user->role,
      'action' => 'Approve Borrow',
      'details' => 'Approved transaction: ' . $tx->id,
      'status' => 'success',
    ]);

    // Create notification for the user
    Notification::create([
      'user_id' => $tx->user_id,
      'type' => 'borrow_approved',
      'title' => 'Borrow Request Approved',
      'message' => 'Your borrow request for "' . optional($tx->book)->title . '" has been approved.',
      'transaction_id' => $tx->id,
      'is_read' => false,
    ]);

    return response()->json(['message' => 'Transaction approved', 'transaction' => $tx]);
  }

  // Admin rejects a pending transaction
  public function adminReject(Request $request, $id)
  {
    $user = Auth::user();
    if (!$user || !in_array($user->role, ['admin', 'super_admin'])) {
      return response()->json(['message' => 'Unauthorized'], 403);
    }

    $tx = BookTransaction::findOrFail($id);

    if ($tx->status === 'rejected') {
      return response()->json(['message' => 'Already rejected'], 422);
    }

    $tx->status = 'rejected';
    $tx->save();

    ActivityLog::create([
      'user_id' => $user->id,
      'user_name' => $user->firstName . ' ' . $user->lastName,
      'role' => $user->role,
      'action' => 'Reject Borrow',
      'details' => 'Rejected transaction: ' . $tx->id,
      'status' => 'success',
    ]);

    // Create notification for the user
    $book = Book::find($tx->book_id);
    Notification::create([
      'user_id' => $tx->user_id,
      'type' => 'borrow_rejected',
      'title' => 'Borrow Request Rejected',
      'message' => 'Your borrow request for "' . optional($book)->title . '" has been rejected.',
      'transaction_id' => $tx->id,
      'is_read' => false,
    ]);

    return response()->json(['message' => 'Transaction rejected', 'transaction' => $tx]);
  }

  // Generate PDF receipt for transaction
  public function downloadReceipt($id)
  {
    $transaction = BookTransaction::with(['user', 'book'])->findOrFail($id);

    $pdf = Pdf::loadView('pdf.transaction-receipt', compact('transaction'));

    return $pdf->download('receipt-' . $transaction->id . '.pdf');
  }
}
