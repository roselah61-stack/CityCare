<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PatientAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access patient dashboard.');
        }

        $user = auth()->user();
        
        // Debug: Log user information
        \Log::info('Patient Access Middleware Check', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'role_id' => $user->role_id,
            'role_name' => $user->role ? $user->role->name : 'No role assigned',
            'requested_url' => $request->fullUrl()
        ]);

        // Allow access for all authenticated users - no restrictions
        \Log::info('Patient Area Access Granted', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'role_name' => $user->role ? $user->role->name : 'No role',
            'access_granted' => true
        ]);

        return $next($request);
    }
}
