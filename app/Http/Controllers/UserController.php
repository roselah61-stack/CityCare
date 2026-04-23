<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        
        if ($user->role->name === 'patient') {
            $patient = \App\Models\Patient::where('email', $user->email)->first();
            if ($patient) {
                return redirect()->route('patient.show', $patient->id);
            }
        }
        
        return view('profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'password' => 'nullable|min:6|confirmed',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }

            $file = $request->file('profile_image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $user->profile_image = 'uploads/'.$filename;
        }
        $user->save();

        return back()->with('success', 'Profile updated successfully');
    }
    public function settings()
{
    return view('settings.index', [
        'settings' => session('settings', [
            'hospital_name' => 'Medicure Hospital',
            'email' => 'admin@hospital.com',
        ])
    ]);
}

public function updateSettings(Request $request)
{
    $request->validate([
        'hospital_name' => 'required|string|max:100',
        'email' => 'required|email',
    ]);

    session([
        'settings' => [
            'hospital_name' => $request->hospital_name,
            'email' => $request->email,
        ]
    ]);

    return back()->with('success', 'System settings updated successfully');
}
}