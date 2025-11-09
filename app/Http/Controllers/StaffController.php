<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookTransaction;
use App\Models\ActivityLog;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    //
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
        $tx->approved_by = $user->id;
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

    // Admin approves a return request
    public function approveReturn(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->role, ['admin', 'super_admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $tx = BookTransaction::with('book')->findOrFail($id);

        if ($tx->status !== 'return_pending') {
            return response()->json(['message' => 'Not a pending return request'], 422);
        }

        $tx->returned_at = now();
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
            'details' => 'Approved return for transaction: ' . $tx->id . ' | Fee: ' . ($tx->fee ?? 0),
            'status' => 'success',
        ]);

        // Create notification for the user
        Notification::create([
            'user_id' => $tx->user_id,
            'type' => 'return_approved',
            'title' => 'Return Approved',
            'message' => 'Your return for "' . optional($tx->book)->title . '" has been approved.' . ($tx->fee > 0 ? ' Overdue fee: ₱' . number_format($tx->fee, 2) : ''),
            'transaction_id' => $tx->id,
            'is_read' => false,
        ]);

        return response()->json(['message' => 'Return approved', 'transaction' => $tx]);
    }

    // Admin rejects a return request (book damaged)
    public function rejectReturn(Request $request, $id)
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
        $damageFee = $request->input('damage_fee');

        $tx->returned_at = now();
        $tx->status = 'damaged';
        $tx->fee = ($tx->fee ?? 0) + $damageFee; // Add damage fee
        $tx->return_approved_by = $user->id;
        $tx->save();

        // Increment book copies (even if damaged, it's returned)
        $book = Book::find($tx->book_id);
        if ($book) {
            $book->increment('copies');
        }

        ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->firstName . ' ' . $user->lastName,
            'role' => $user->role,
            'action' => 'Reject Return (Damaged)',
            'details' => 'Rejected return for transaction: ' . $tx->id . ' | Reason: ' . $reason . ' | Total Fee: ₱' . number_format($tx->fee, 2) . ' (includes ₱' . number_format($damageFee, 2) . ' damage fee)',
            'status' => 'success',
        ]);

        // Create notification for the user
        Notification::create([
            'user_id' => $tx->user_id,
            'type' => 'return_rejected',
            'title' => 'Return Rejected - Book Damaged',
            'message' => 'Your return for "' . optional($tx->book)->title . '" was rejected. Reason: ' . $reason . '. Total fee: ₱' . number_format($tx->fee, 2) . ' (includes ₱' . number_format($damageFee, 2) . ' damage charge)',
            'transaction_id' => $tx->id,
            'is_read' => false,
        ]);

        return response()->json(['message' => 'Return rejected - damage fee applied', 'transaction' => $tx]);
    }
}
