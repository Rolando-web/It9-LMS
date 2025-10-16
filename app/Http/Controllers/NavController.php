<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavController extends Controller
{
    // In LoginController.php
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function home()
    {
        return view('layouts.app');
    }

    public function book()
    {
        return view('pages.book-return');
    }

    public function collection()
    {
        return view('pages.book-collection');
    }

    public function transaction()
    {
        return view('pages.user-transaction');
    }
}
