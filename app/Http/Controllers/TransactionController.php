<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\BookTransaction;
use App\Models\ActivityLog;
use App\Models\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

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

    // Create transaction and decrement copies atomically
    $tx = DB::transaction(function () use ($user, $book, $request) {
      // re-check stock inside transaction
      $bookFresh = Book::lockForUpdate()->find($book->id);
      if (!$bookFresh || $bookFresh->copies <= 0) {
        abort(response()->json(['message' => 'No copies available'], 422));
      }

      $bookFresh->decrement('copies');

      return BookTransaction::create([
        'user_id' => $user->id,
        'book_id' => $bookFresh->id,
        'borrowed_at' => now(),
        'due_date' => $request->due_date,
        'status' => 'pending',
      ]);
    });

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

  // Return flow moved to ReturnTransactionController

  // Generate PDF receipt for transaction
  public function downloadReceipt($id)
  {
    $transaction = BookTransaction::with(['user', 'book', 'approver'])->findOrFail($id);
    $pdf = Pdf::loadView('pdf.transaction-receipt', compact('transaction'));
    return $pdf->download('receipt-' . $transaction->id . '.pdf');
  }
}
