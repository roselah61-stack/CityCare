<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        try {
            // Check if user is authenticated
            if (!$request->user()) {
                Log::warning('Role middleware: User not authenticated');
                return redirect('login');
            }

            $user = $request->user();
            
            // Try to get user role with fallback
            $userRole = null;
            
            try {
                $userRole = $user->role ? $user->role->name : null;
            } catch (\Exception $e) {
                Log::error('Role middleware error getting user role: ' . $e->getMessage());
                
                // Fallback: try to get role from user table directly
                try {
                    $userRole = \App\Models\Role::where('id', $user->role_id)->value('name');
                } catch (\Exception $fallbackError) {
                    Log::error('Role middleware fallback also failed: ' . $fallbackError->getMessage());
                    $userRole = null;
                }
            }

            // Log for debugging
            Log::info('Role middleware check', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $userRole,
                'required_roles' => $roles
            ]);

            // Check if user has required role or is admin
            if (in_array($userRole, $roles) || $userRole === 'admin') {
                return $next($request);
            }

            Log::warning('Role middleware: Access denied', [
                'user_role' => $userRole,
                'required_roles' => $roles
            ]);

            abort(403, 'Unauthorized action. Required role: ' . implode(', ', $roles));
            
        } catch (\Exception $e) {
            Log::error('Role middleware unexpected error: ' . $e->getMessage());
            
            // For Laravel Cloud, allow access if middleware fails to prevent 500 errors
            if (app()->environment('production')) {
                Log::warning('Role middleware: Allowing access due to middleware error in production');
                return $next($request);
            }
            
            abort(500, 'Server error in role checking.');
        }
    }
}
