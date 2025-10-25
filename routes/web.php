<?php

use App\Http\Controllers\NavController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

// Guest Routes (for non-authenticated users only)
Route::middleware(['guest'])->group(function () {
  Route::get('/', [AuthController::class, 'showLoginForm']);
  Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [AuthController::class, 'login']);
  Route::get('/register', [NavController::class, 'register'])->name('register');
  Route::post('/register', [AuthController::class, 'register']);

  // Password Reset (Forgot Password)
  Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
  Route::post('/forgot-password', [AuthController::class, 'checkEmail'])->name('password.check');
  Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset');
  Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

//User Routes (Protected by user middleware - regular users only)
Route::middleware(['user'])->group(function () {
  Route::get('/app', [NavController::class, 'home'])->name('home');
  Route::get('/book-collection', [NavController::class, 'collection'])->name('collection');
  Route::get('/book-return', [NavController::class, 'book'])->name('book');
  Route::get('/user-transaction', [NavController::class, 'transaction'])->name('user-transaction');
});

//Admin Routes (Protected by admin middleware - allows both admin and super_admin)
Route::middleware(['admin'])->group(function () {
  Route::get('/dashboard', [NavController::class, 'dashboard'])->name('dashboard');
  Route::get('/books', [NavController::class, 'books'])->name('books');
  Route::get('/transaction', [NavController::class, 'transactions'])->name('transactions');
  Route::get('/categories', [NavController::class, 'categories'])->name('categories');
  Route::get('/activity-log', [NavController::class, 'activitylog'])->name('activity-log');

  // Book Management Routes
  Route::post('/create-book', [BookController::class, 'saveBook'])->name('create');
  Route::post('/update-book', [BookController::class, 'updateBook'])->name('update-book');
  Route::delete('/delete-book/{id}', [BookController::class, 'destroy'])->name('delete-book');
});

//Super Admin Only Routes (Protected by super_admin middleware)
Route::middleware(['super_admin'])->group(function () {
  Route::get('/user-admin', [NavController::class, 'useradmin'])->name('user-admin');
});

// Logout route (accessible to all authenticated users)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
