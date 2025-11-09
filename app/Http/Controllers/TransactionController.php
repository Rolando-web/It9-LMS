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

    $tx = BookTransaction::create([
      'user_id' => $user->id,
      'book_id' => $book->id,
      'borrowed_at' => now(),
      'due_date' => $request->due_date,
      'status' => 'pending',
    ]);

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

  // Return a borrowed book - now submits return request for admin approval
  public function return(Request $request, $id)
  {
    $user = Auth::user();
    if (!$user) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    $tx = BookTransaction::where('id', $id)->where('user_id', $user->id)->firstOrFail();

    if (in_array($tx->status, ['returned', 'return_pending', 'damaged'])) {
      return response()->json(['message' => 'Return already processed or pending'], 422);
    }

    // Calculate potential overdue fee
    $due = \Carbon\Carbon::parse($tx->due_date);
    $returned = \Carbon\Carbon::now();
    $daysOver = 0;
    if ($returned->greaterThan($due)) {
      $daysOver = $returned->startOfDay()->diffInDays($due->startOfDay());
    }

    $fee = $daysOver * 50;

    $tx->return_requested_at = now();
    $tx->days_overdue = $daysOver;
    $tx->fee = $fee;
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

    // Create notification for admins
    $admins = \App\Models\User::whereIn('role', ['admin', 'super_admin'])->get();
    foreach ($admins as $admin) {
      Notification::create([
        'user_id' => $admin->id,
        'type' => 'return_request',
        'title' => 'Book Return Request',
        'message' => $user->firstName . ' ' . $user->lastName . ' requested to return "' . ($book ? $book->title : 'Book') . '"',
        'transaction_id' => $tx->id,
        'is_read' => false,
      ]);
    }

    return response()->json(['message' => 'Return request submitted. Please wait for admin approval.', 'transaction' => $tx]);
  }

  // Generate PDF receipt for transaction
  public function downloadReceipt($id)
  {
    $transaction = BookTransaction::with(['user', 'book', 'approver'])->findOrFail($id);
    $pdf = Pdf::loadView('pdf.transaction-receipt', compact('transaction'));
    return $pdf->download('receipt-' . $transaction->id . '.pdf');
  }
}
