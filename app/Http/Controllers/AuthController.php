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
     * Show admin login form
     */
    public function showAdminLogin()
    {
        // Redirect to dashboard if already logged in
        if (Auth::check()) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }
        
        return view('auth.admin-login');
    }

    /**
     * Show level 1 login form
     */
    public function showLevel1Login()
    {
        // Redirect to dashboard if already logged in
        if (Auth::check()) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }
        
        return view('auth.level1-login');
    }

    /**
     * Show level 2 login form
     */
    public function showLevel2Login()
    {
        // Redirect to dashboard if already logged in
        if (Auth::check()) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }
        
        return view('auth.level2-login');
    }

    /**
     * Show level 3 login form
     */
    public function showLevel3Login()
    {
        // Redirect to dashboard if already logged in
        if (Auth::check()) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }
        
        return view('auth.level3-login');
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

        // Redirect to appropriate dashboard
        return redirect()->route($user->getDashboardRoute());
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