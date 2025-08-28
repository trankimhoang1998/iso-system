<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        $user = auth()->user();
        
        // Convert role to integer if it's a string
        $requiredRole = is_numeric($role) ? (int)$role : $role;
        
        if ($user->role !== $requiredRole) {
            // Redirect to appropriate dashboard based on user's role
            return redirect()->route($user->getDashboardRoute());
        }

        // Check if user is active
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('home')->with('error', 'Tài khoản đã bị vô hiệu hóa.');
        }

        return $next($request);
    }
}
