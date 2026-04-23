<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        try {
            // Check database connectivity first
            try {
                DB::connection()->getPdo();
            } catch (\Exception $e) {
                \Log::error('Database connection failed during registration: ' . $e->getMessage());
                return back()->with('error', 'Database connection failed. Please contact administrator.');
            }

            $isFirstUser = User::count() === 0;
            $roleName = $isFirstUser ? 'admin' : 'doctor';
            
            // Handle case where roles table doesn't exist or is empty
            $roleId = null;
            try {
                $role = Role::where('name', $roleName)->first();
                $roleId = $role->id ?? null;
            } catch (\Exception $e) {
                // If roles table doesn't exist, continue without role
                \Log::warning('Roles table not accessible during registration: ' . $e->getMessage());
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $roleId
            ]);

            event(new \Illuminate\Auth\Events\Registered($user));

            Auth::login($user);

            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            \Log::error('Registration error: ' . $e->getMessage());
            return back()->with('error', 'Registration failed. Please try again. Error: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}