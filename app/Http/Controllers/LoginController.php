<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request) {
        // Validate the email and password before we use it
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
            return response()->json(Auth::user(), 200);
        }
        // If it failed, give error message
        throw ValidationException::withMessages([
            'email' => ['The provided credentials were incorrect.']
        ]);
    }

    public function logout() {
        Auth::logout();
    }
}
