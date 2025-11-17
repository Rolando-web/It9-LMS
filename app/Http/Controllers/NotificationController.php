<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
  // Get user's notifications
  public function getNotifications()
  {
    $user = Auth::user();
    if (!$user) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    $notifications = Notification::where('user_id', $user->id)
      ->orderByDesc('created_at')
      ->limit(10)
      ->get();

    $unreadCount = Notification::where('user_id', $user->id)
      ->where('is_read', false)
      ->count();

    return response()->json([
      'notifications' => $notifications,
      'unread_count' => $unreadCount
    ]);
  }

  // Mark notification as read
  public function markNotificationAsRead($id)
  {
    $user = Auth::user();
    if (!$user) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    $notification = Notification::where('id', $id)
      ->where('user_id', $user->id)
      ->firstOrFail();

    $notification->is_read = true;
    $notification->save();

    return response()->json(['message' => 'Notification marked as read']);
  }
  // Send notification to all admins about a return request
  public static function returnRequestToAdmins(int $transactionId, string $bookTitle, string $requesterName): void
  {
    $admins = User::whereIn('role', ['admin', 'super_admin'])->get(['id']);
    foreach ($admins as $admin) {
      Notification::create([
        'user_id' => $admin->id,
        'type' => 'return_request',
        'title' => 'Book Return Request',
        'message' => $requesterName . ' requested to return "' . ($bookTitle ?: 'Book') . '"',
        'transaction_id' => $transactionId,
        'is_read' => false,
      ]);
    }
  }

  public static function borrowApproved(int $userId, int $transactionId, string $bookTitle): void
  {
    Notification::create([
      'user_id' => $userId,
      'type' => 'borrow_approved',
      'title' => 'Borrow Request Approved',
      'message' => 'Your borrow request for "' . $bookTitle . '" has been approved.',
      'transaction_id' => $transactionId,
      'is_read' => false,
    ]);
  }

  public static function borrowRejected(int $userId, int $transactionId, string $bookTitle): void
  {
    Notification::create([
      'user_id' => $userId,
      'type' => 'borrow_rejected',
      'title' => 'Borrow Request Rejected',
      'message' => 'Your borrow request for "' . $bookTitle . '" has been rejected.',
      'transaction_id' => $transactionId,
      'is_read' => false,
    ]);
  }

  public static function returnApproved(int $userId, int $transactionId, string $bookTitle, float $fee = 0, int $daysOverdue = 0): void
  {
    $feeMessage = '';
    if ($fee > 0) {
      $feeMessage = ' Total Book Fee: ₱' . number_format($fee, 2);
      if ($daysOverdue > 0) {
        $feeMessage .= ' (' . $daysOverdue . ' days overdue)';
      }
    }
    Notification::create([
      'user_id' => $userId,
      'type' => 'return_approved',
      'title' => 'Return Approved',
      'message' => 'Your return for "' . $bookTitle . '" has been approved.' . $feeMessage,
      'transaction_id' => $transactionId,
      'is_read' => false,
    ]);
  }

  public static function returnRejectedDamaged(int $userId, int $transactionId, string $bookTitle, string $reason, float $totalFee, ?float $overdueFee = null, ?float $damageFee = null): void
  {
    $feeBreakdown = 'Total Book Fee: ₱' . number_format(max(0, $totalFee), 2);
    if (!is_null($overdueFee) && $overdueFee > 0 && !is_null($damageFee) && $damageFee > 0) {
      $feeBreakdown .= ' (Overdue: ₱' . number_format($overdueFee, 2) . ' + Damage: ₱' . number_format($damageFee, 2) . ')';
    } elseif (!is_null($damageFee) && $damageFee > 0) {
      $feeBreakdown .= ' (Damage fee)';
    } elseif (!is_null($overdueFee) && $overdueFee > 0) {
      $feeBreakdown .= ' (Overdue fee)';
    }

    Notification::create([
      'user_id' => $userId,
      'type' => 'return_rejected',
      'title' => 'Return Rejected - Book Damaged',
      'message' => 'Your return for "' . $bookTitle . '" was rejected. Reason: ' . $reason . '. ' . $feeBreakdown,
      'transaction_id' => $transactionId,
      'is_read' => false,
    ]);
  }
}
