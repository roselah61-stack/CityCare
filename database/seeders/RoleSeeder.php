<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
 use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   

public function run()
{
    $roles = ['admin', 'doctor', 'pharmacist', 'receptionist', 'patient', 'cashier'];

    foreach ($roles as $role) {
        Role::updateOrCreate(['name' => $role]);
    }
}
}
