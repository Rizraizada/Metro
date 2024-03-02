<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User; // Assuming it's 'App\Models\User', please adjust if it's different

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showregistration()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->usertype == 1) {
                return redirect()->route('admin.accounts');
            }
        }

        return redirect()->route('login')->with('error', 'Invalid credentials');
    }


    public function logout()
    {
        Auth::logout();

        return redirect(url('/login'));
    }
}
