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
        // Copies are now decremented at borrow request time

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
        \App\Http\Controllers\NotificationController::borrowApproved(
            $tx->user_id,
            $tx->id,
            optional($tx->book)->title ?? 'Book'
        );

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

        // Since we decrement on borrow, return the copy to inventory on reject
        $book = Book::find($tx->book_id);
        if ($book) {
            $book->increment('copies');
        }

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
        \App\Http\Controllers\NotificationController::borrowRejected(
            $tx->user_id,
            $tx->id,
            optional($book)->title ?? 'Book'
        );

        return response()->json(['message' => 'Transaction rejected', 'transaction' => $tx]);
    }

    // Return approval/rejection moved to ReturnTransactionController
}
