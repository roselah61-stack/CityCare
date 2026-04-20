<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
{
    User::create([
        'name' => 'Admin',
        'email' => 'admin@medicure.com',
        'password' => bcrypt('password'),
        'role_id' => 1
    ]);

    User::create([
        'name' => 'Doctor',
        'email' => 'doctor@medicure.com',
        'password' => bcrypt('password'),
        'role_id' => 2
    ]);

    User::create([
        'name' => 'Pharmacist',
        'email' => 'pharma@medicure.com',
        'password' => bcrypt('password'),
        'role_id' => 3
    ]);
}
}
