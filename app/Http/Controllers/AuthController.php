<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show unified login form
     */
    public function showLogin()
    {
        // Redirect to trang-chu if already logged in
        if (Auth::check()) {
            return redirect()->route('trang-chu');
        }
        
        return view('auth.login');
    }


    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|integer|in:0,1,2,3'
        ]);

        $user = User::where('email', $request->email)
                   ->where('role', $request->role)
                   ->where('is_active', true)
                   ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Thông tin đăng nhập không chính xác.',
            ]);
        }

        Auth::login($user, $request->filled('remember'));

        $request->session()->regenerate();

        // Redirect to home page first for all roles
        return redirect()->route('trang-chu');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}