<?php

namespace App\Http\Controllers\Auth;

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::logout();
                return back()->with('error', 'Ju lutem verifikoni emailin tuaj.');
            }

            return redirect()->route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'home');
        }

        return back()->with('error', 'Email ose fjalëkalim i pasaktë!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

