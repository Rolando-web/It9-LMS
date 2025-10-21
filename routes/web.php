<?php

use App\Http\Controllers\NavController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

Route::get('/', function () {
  return view('auth.login');
});

// In web.php
Route::get('/register', [NavController::class, 'register'])->name('register');
Route::get('/app', [NavController::class, 'home'])->name('home');
Route::get('/book-collection', [NavController::class, 'collection'])->name('collection');
Route::get('/book-return', [NavController::class, 'book'])->name('book');
Route::get('/user-transaction', [NavController::class, 'transaction'])->name('transaction');

//Admin Routes
Route::get('/dashboard', [NavController::class, 'dashboard'])->name('dashboard');
Route::get('/books', [NavController::class, 'books'])->name('books');
Route::get('/transaction', [NavController::class, 'transactions'])->name('transactions');
Route::get('/categories', [NavController::class, 'categories'])->name('categories');


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', function () {
  return view('auth.login');
})->name('login');

// CreateBook
Route::post('/create-book', [BookController::class, 'saveBook'])->name('create');


// Authentication Routes
// Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [AuthController::class, 'register']);
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
