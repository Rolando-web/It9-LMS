<?php

use App\Http\Controllers\NavController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
  return view('auth.login');
});

// In web.php
// Route::get('/login', [NavController::class, 'login'])->name('login');
// Route::get('/register', [NavController::class, 'register'])->name('register');
Route::get('/app', [NavController::class, 'home'])->name('home');
Route::get('/book-collection', [NavController::class, 'collection'])->name('collection');
Route::get('/book-return', [NavController::class, 'book'])->name('book');
Route::get('/user-transaction', [NavController::class, 'transaction'])->name('transaction');


// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
  Route::get('/dashboard', [UserController::class, 'home'])->name('home');
});
