<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PayMongoController;
use App\Http\Controllers\ReturnTransactionController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

// Guest Routes
Route::middleware(['guest'])->group(function () {
  Route::get('/', [AuthController::class, 'showLoginForm']);
  Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [AuthController::class, 'login']);
  Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
  Route::post('/register', [AuthController::class, 'register']);


  // Password Reset
  Route::get('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
  Route::post('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
  // Graceful handler when token is missing
  Route::get('/reset-password', function () {
    return redirect()->route('password.request')->withErrors(['email' => 'Please enter your email to continue resetting your password.']);
  });
  Route::get('/reset-password/{token}', [\App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->name('password.reset');
  Route::post('/reset-password', [\App\Http\Controllers\PasswordResetController::class, 'reset'])->name('password.update');
});

//User Routes 
Route::middleware(['user'])->group(function () {
  Route::get('/app', [AuthController::class, 'home'])->name('home');
  Route::get('/book-collection', [BookController::class, 'collection'])->name('collection');
  Route::get('/books/load-more', [BookController::class, 'loadMoreBooks'])->name('books.load');
  Route::get('/book-return', [TransactionController::class, 'bookReturn'])->name('book');
  Route::get('/user-transaction', [TransactionController::class, 'userTransactions'])->name('user-transaction');
  Route::post('/borrow', [TransactionController::class, 'borrow'])->middleware('auth');
  Route::delete('/borrow/cancel/{id}', [TransactionController::class, 'cancelBorrow'])->name('borrow.cancel')->middleware('auth');
  Route::post('/return/{id}', [ReturnTransactionController::class, 'request'])->name('transactions.return.request')->middleware('auth');

  // Notification routes
  Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.get');
  Route::post('/notifications/{id}/read', [NotificationController::class, 'markNotificationAsRead'])->name('notifications.read');

  // Payment routes
  Route::post('/payment/create', [PayMongoController::class, 'createPayment'])->name('payment.create');
  Route::get('/payment/callback', [PayMongoController::class, 'paymentCallback'])->name('payment.callback');
  Route::get('/payment/failed', [PayMongoController::class, 'paymentFailed'])->name('payment.failed');
});

//Admin Routes
Route::middleware(['admin'])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
  Route::get('/dashboard/date', [DashboardController::class, 'dashboardByDate'])->name('dashboard.byDate');
  Route::get('/dashboard/report', [DashboardController::class, 'downloadReport'])->name('dashboard.report');
  Route::get('/books', [BookController::class, 'adminBooks'])->name('books');
  Route::get('/transaction', [TransactionController::class, 'adminTransactions'])->name('transactions');
  Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
  Route::get('/activity-log', [DashboardController::class, 'activitylog'])->name('activity-log');
  Route::get('/staff', [DashboardController::class, 'staff'])->name('staff');

  // Admin approve/reject endpoints for borrow requests
  Route::post('/admin/transactions/{id}/approve', [StaffController::class, 'adminApprove'])->name('admin.transactions.approve');
  Route::post('/admin/transactions/{id}/reject', [StaffController::class, 'adminReject'])->name('admin.transactions.reject');

  // Admin approve/reject endpoints for return requests
  Route::post('/admin/transactions/{id}/approve-return', [ReturnTransactionController::class, 'approve'])->name('admin.transactions.approve-return');
  Route::post('/admin/transactions/{id}/reject-return', [ReturnTransactionController::class, 'reject'])->name('admin.transactions.reject-return');

  // Book Management Routes
  Route::post('/create-book', [BookController::class, 'saveBook'])->name('create');
  Route::post('/update-book', [BookController::class, 'updateBook'])->name('update-book');
  Route::delete('/delete-book/{id}', [BookController::class, 'destroy'])->name('delete-book');

  // Category API Routes
  Route::get('/api/categories', [CategoryController::class, 'getAllCategories'])->name('categories.all');
  Route::get('/api/categories/filter', [CategoryController::class, 'getCategoriesForFilter'])->name('categories.filter');
});

//Super Admin
Route::middleware(['super_admin'])->group(function () {
  Route::get('/user-admin', [DashboardController::class, 'useradmin'])->name('user-admin');
  Route::post('/user-admin/add', [UserController::class, 'store'])->name('user.store');
  Route::put('/user-admin/{id}', [UserController::class, 'update'])->name('user.update');
  Route::delete('/user-admin/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Download transaction receipt PDF
Route::get('/transaction/{id}/receipt', [TransactionController::class, 'downloadReceipt'])->name('transaction.receipt')->middleware('auth');

Route::post('/webhooks/paymongo', [PayMongoController::class, 'handleWebhook'])->name('webhooks.paymongo');
