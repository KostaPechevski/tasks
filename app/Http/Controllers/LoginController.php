<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(Auth::attempt($request->only('username', 'password'))) {
            return response()->json(Auth::user(), 200);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
        ]);

    }

    public function logout() {
        Auth::logout();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
