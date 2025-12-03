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

    // Create transaction and -1 COPIES
    $tx = DB::transaction(function () use ($user, $book, $request) {
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

  // Generate PDF 
  public function downloadReceipt($id)
  {
    $user = Auth::user();
    if (!$user) {
      abort(403, 'Unauthorized access.');
    }

    $transaction = BookTransaction::with(['user', 'book', 'approver'])->findOrFail($id);
    
    // Allow if user is admin/super_admin OR owns the transaction
    $isAdmin = in_array($user->role, ['admin', 'super_admin']);
    $ownsTransaction = $transaction->user_id === $user->id;
    
    if (!$isAdmin && !$ownsTransaction) {
      abort(403, 'Unauthorized access. You can only download receipts for your own transactions.');
    }

    $pdf = Pdf::loadView('pdf.transaction-receipt', compact('transaction'));
    return $pdf->download('receipt-' . $transaction->id . '.pdf');
  }

  // Cancel pending borrow request
  public function cancelBorrow($id)
  {
    $user = Auth::user();
    if (!$user) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    $tx = BookTransaction::with('book')->findOrFail($id);

    // Verify the transaction belongs to the user
    if ($tx->user_id !== $user->id) {
      return response()->json(['message' => 'Unauthorized to cancel this transaction'], 403);
    }

    // Only pending transactions can be cancelled
    if ($tx->status !== 'pending') {
      return response()->json(['message' => 'Only pending borrow requests can be cancelled'], 422);
    }

    // Delete the transaction and restore book copy
    DB::transaction(function () use ($tx) {
      $book = Book::lockForUpdate()->find($tx->book_id);
      if ($book) {
        $book->increment('copies');
      }
      $tx->delete();
    });

    // Log activity
    ActivityLog::create([
      'user_id' => $user->id,
      'user_name' => $user->firstName . ' ' . $user->lastName,
      'role' => $user->role,
      'action' => 'Cancel Borrow',
      'details' => 'Cancelled pending borrow request for: ' . $tx->book->title,
      'status' => 'success',
    ]);

    return response()->json(['message' => 'Borrow request cancelled successfully'], 200);
  }

  // User book return view
  public function bookReturn()
  {
    $user = Auth::user();
    if (!$user) {
      return redirect()->route('login');
    }

    $borrowed = BookTransaction::with('book')
      ->where('user_id', $user->id)
      ->whereIn('status', ['pending', 'borrowed'])
      ->orderByDesc('borrowed_at')
      ->get();

    return view('pages.book-return', compact('borrowed'));
  }

  // User transaction history view
  public function userTransactions()
  {
    $user = Auth::user();
    if (!$user) {
      return redirect()->route('login');
    }

    $perPage = 10;

    // Active: currently not finalized transactions
    // - borrowed (not returned)
    // - overdue but not yet returned
    // - return_pending (awaiting staff action)
    $active = BookTransaction::with('book')
      ->where('user_id', $user->id)
      ->where(function ($q) {
        $q->whereIn('status', ['borrowed', 'return_pending'])
          ->orWhere(function ($qq) {
            $qq->where('status', 'overdue')
              ->whereNull('returned_at');
          });
      })
      ->orderByDesc('borrowed_at')
      ->paginate($perPage, ['*'], 'active_page');

    // History: finalized transactions (returned, damaged, and overdue that were returned)
    $history = BookTransaction::with('book')
      ->where('user_id', $user->id)
      ->whereIn('status', ['returned', 'damaged', 'overdue'])
      ->whereNotNull('returned_at')
      ->orderByDesc('borrowed_at')
      ->paginate($perPage, ['*'], 'history_page');

    $totalTransactions = BookTransaction::where('user_id', $user->id)->count();
    $overdueCount = BookTransaction::where('user_id', $user->id)->where('status', 'overdue')->count();

    // Outstanding fees: sum the stored 'fee' field for all finalized transactions
    // This includes returned, damaged, return_pending, and overdue (with returned_at)
    // The fee field is managed by PayMongoController and deducted as payments are made
    $storedFees = BookTransaction::where('user_id', $user->id)
      ->where(function($q) {
        // All finalized transactions with stored fees
        $q->whereIn('status', ['returned', 'damaged', 'return_pending'])
          ->orWhere(function($qq) {
            // Overdue transactions that have been returned
            $qq->where('status', 'overdue')->whereNotNull('returned_at');
          });
      })
      ->sum('fee');

    // Add LIVE overdue for unreturned items past due date (+50/day)
    $now = \Carbon\Carbon::now()->startOfDay();
    $liveOverdueFees = BookTransaction::where('user_id', $user->id)
      ->whereIn('status', ['borrowed', 'overdue'])
      ->whereNull('returned_at')
      ->whereNotNull('due_date')
      ->get(['due_date'])
      ->sum(function ($tx) use ($now) {
        $due = \Carbon\Carbon::parse($tx->due_date)->startOfDay();
        if ($now->greaterThan($due)) {
          return $due->diffInDays($now) * 50;
        }
        return 0;
      });

    $outstandingFees = max(0, $storedFees + $liveOverdueFees);

    // Total fee (historical + active frozen fees) for user summary
    // For completeness, keep totalUserFees aligned with outstanding today
    $totalUserFees = $outstandingFees;

    return view('pages.user-transaction', compact('active', 'history', 'totalTransactions', 'overdueCount', 'outstandingFees', 'totalUserFees'));
  }

  // Admin transactions view
  public function adminTransactions()
  {
    $transactions = BookTransaction::with(['user', 'book'])
      ->orderByDesc('created_at')
      ->paginate(10);

    // Calculate statistics
    $totalBorrowed = BookTransaction::whereIn('status', ['pending', 'borrowed', 'overdue'])->count();
    $totalReturned = BookTransaction::where('status', 'returned')->count();
    $totalOverdue = BookTransaction::where('status', 'overdue')->count();

    // Calculate total fees: stored fees for finalized transactions + live overdue for active borrowings
    // Stored fees (already accounts for payments made via PayMongo)
    $storedFees = BookTransaction::where(function($q) {
        $q->whereIn('status', ['returned', 'damaged', 'return_pending'])
          ->orWhere(function($qq) {
            $qq->where('status', 'overdue')->whereNotNull('returned_at');
          });
      })
      ->sum('fee');

    // Live overdue fees for unreturned books
    $today = \Carbon\Carbon::now()->startOfDay();
    $liveOverdueFees = BookTransaction::whereIn('status', ['borrowed', 'overdue'])
      ->whereNull('returned_at')
      ->whereNotNull('due_date')
      ->get(['due_date'])
      ->sum(function ($tx) use ($today) {
        $dueDate = \Carbon\Carbon::parse($tx->due_date)->startOfDay();
        if ($today->greaterThan($dueDate)) {
          return $dueDate->diffInDays($today) * 50;
        }
        return 0;
      });

    $totalFees = max(0, $storedFees + $liveOverdueFees);

    return view('Admin.transaction', compact(
      'transactions',
      'totalBorrowed',
      'totalReturned',
      'totalOverdue',
      'totalFees'
    ));
  }
}
