<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function index(){
        return view('pages.profile');
    }

    public function delete(){
        User::findOrFail(auth()->id())->delete();

        return redirect()->route('home');
    }

    public function showChangePassword(){
        return view('pages.change-password');
    }

    public function changePassword(Request $req){
        $validated = $req->validate([
            'password' => ['string', 'required', 'max:255'],
            'new_password' => ['string', 'required', 'max:255', 'min:8'],
            'confirm_new_password' => ['string', 'required', 'max:255', 'min:8']
        ]);

        if($validated['new_password'] != $validated['confirm_new_password'])throw ValidationException::withMessages(['new_password' => 'confirmation does not match']);

        if(auth()->user() && Hash::check($validated['password'], auth()->user()->password)){
            User::findOrFail(auth()->id())->update([
                'password' => $validated['new_password']
            ]);
        }
        else throw ValidationException::withMessages(['password' => 'wrong password']);

        Auth::logout();

        return redirect()->route('login');
    }
}
