<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\BookTransaction;
use App\Models\ActivityLog;

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

    if ($book->copies <= 0) {
      return response()->json(['message' => 'No copies available'], 422);
    }

    // create transaction
    $tx = BookTransaction::create([
      'user_id' => $user->id,
      'book_id' => $book->id,
      'borrowed_at' => now(),
      'due_date' => $request->due_date,
      'status' => 'borrowed',
    ]);

    // decrement book copies
    $book->decrement('copies');

    // log activity
    ActivityLog::create([
      'user_id' => $user->id,
      'user_name' => $user->firstName . ' ' . $user->lastName,
      'role' => $user->role,
      'action' => 'Borrow Book',
      'details' => 'Borrowed book: ' . $book->title,
      'status' => 'success',
    ]);

    return response()->json(['message' => 'Book borrowed', 'transaction' => $tx], 201);
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
    // if returned after due date, diffInDays will be positive when returned > due; adjust
    if ($returned->greaterThan($due)) {
      $daysOver = $returned->startOfDay()->diffInDays($due->startOfDay());
    } else {
      $daysOver = 0;
    }

    // fee: increased by 50 per overdue day
    $fee = $daysOver * 50;

    $tx->days_overdue = $daysOver;
    $tx->fee = $fee;
    $tx->status = $daysOver > 0 ? 'overdue' : 'returned';
    $tx->save();

    // increment book copies
    $book = Book::find($tx->book_id);
    if ($book) $book->increment('copies');

    // log activity
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
}
