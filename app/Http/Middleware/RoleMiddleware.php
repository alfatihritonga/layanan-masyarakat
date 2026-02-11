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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            // Return JSON for API requests
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please login first.'
                ], 401);
            }
            
            // Redirect to login for web requests
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Check if user has required role
        if (!in_array($user->role, $roles)) {
            // Return JSON for API requests
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden. You do not have permission to access this resource.',
                    'required_roles' => $roles,
                    'your_role' => $user->role
                ], 403);
            }
            
            // Abort for web requests
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }
        
        return $next($request);
    }
}
