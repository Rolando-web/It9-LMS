<?php

use App\Http\Controllers\NavController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

Route::get('/', function () {
  return view('auth.login');
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


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [NavController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', function () {
  return view('auth.login');
})->name('login');


// Authentication Routes
// Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [AuthController::class, 'register']);
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
