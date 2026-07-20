<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showRegister() {
        return view('pages.register');
    }

    public function showLogin() {
        return view('pages.login');
    }
}
