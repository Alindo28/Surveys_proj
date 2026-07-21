<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showRegister() {
        return view('pages.register');
    }

    public function showLogin() {
        return view('pages.login');
    }

    public function register(Request $req) {
        $validated = $req->validate([
            'full_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create($validated);
        Auth::login($user);

        return redirect()->route('survey_home');
    }

    public function login(Request $req)
    {
        $validated = $req->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($validated)) {
            $req->session()->regenerate();

            return redirect()->route('survey_home');
        }

        throw ValidationException::withMessages([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function logout(Request $req){
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect()->route('home');
    }
}
