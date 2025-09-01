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
    public function handle(Request $request, Closure $next, $roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('home');
        }

        $user = auth()->user();
        
        // Handle multiple roles separated by pipe
        $allowedRoles = [];
        if (strpos($roles, '|') !== false) {
            // Multiple roles like "0|1"
            $roleArray = explode('|', $roles);
            foreach ($roleArray as $role) {
                $allowedRoles[] = is_numeric(trim($role)) ? (int)trim($role) : trim($role);
            }
        } else {
            // Single role
            $allowedRoles[] = is_numeric($roles) ? (int)$roles : $roles;
        }
        
        
        if (!in_array($user->role, $allowedRoles)) {
            // Return 404 when user tries to access restricted area
            abort(404);
        }

        // Check if user is active
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('home')->with('error', 'Tài khoản đã bị vô hiệu hóa.');
        }

        return $next($request);
    }
}
