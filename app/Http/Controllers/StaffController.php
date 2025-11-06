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
}
