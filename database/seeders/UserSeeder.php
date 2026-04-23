<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $roles = Role::all();

        foreach ($roles as $role) {
            User::updateOrCreate(
                ['email' => $role->name . '@citycare.com'],
                [
                    'name' => ucfirst($role->name) . ' User',
                    'password' => Hash::make('password'),
                    'role_id' => $role->id,
                ]
            );
        }

        // Create some extra doctors
        $doctorRole = Role::where('name', 'doctor')->first();
        if ($doctorRole) {
            User::updateOrCreate(['email' => 'smith@citycare.com'], ['name' => 'Dr. John Smith', 'password' => Hash::make('password'), 'role_id' => $doctorRole->id]);
            User::updateOrCreate(['email' => 'doe@citycare.com'], ['name' => 'Dr. Jane Doe', 'password' => Hash::make('password'), 'role_id' => $doctorRole->id]);
        }
    }
}
