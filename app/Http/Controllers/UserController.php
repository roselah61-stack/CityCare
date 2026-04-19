<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = session()->get('user', [
            'name' => 'Admin',
            'image' => null
        ]);

        $user['name'] = $request->name;

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);

            $user['image'] = 'uploads/'.$filename;
        }

        session(['user' => $user]);

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