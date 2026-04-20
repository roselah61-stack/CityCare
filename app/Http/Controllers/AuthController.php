<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid credentials');
        }

        $otp = rand(100000, 999999);

        session([
            '2fa_user_id' => $user->id,
            '2fa_code' => $otp
        ]);

        Mail::to($user->email)->send(new TwoFactorCodeMail($otp));

        return redirect()->route('2fa.form');
    }

    public function showOtp()
    {
        if (!session('2fa_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        if (!session('2fa_user_id')) {
            return redirect()->route('login');
        }

        if ($request->otp != session('2fa_code')) {
            return back()->with('error', 'Invalid OTP');
        }

        $user = User::find(session('2fa_user_id'));

        if (!$user) {
            return redirect()->route('login');
        }

        Auth::login($user);

        session()->forget(['2fa_user_id', '2fa_code']);

        return redirect()->route('dashboard');
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

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => null
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully. Please login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}