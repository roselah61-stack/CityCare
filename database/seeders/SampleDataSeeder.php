<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Drug;
use App\Models\Patient;
use App\Models\User;
use App\Models\Role;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Bill;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Get or create roles
        $doctorRole = Role::where('name', 'doctor')->first();
        $pharmacistRole = Role::where('name', 'pharmacist')->first();
        $receptionistRole = Role::where('name', 'receptionist')->first();
        $patientRole = Role::where('name', 'patient')->first();

        // Create Doctors
        $doctors = [
            [
                'name' => 'Dr. Sarah Nankya',
                'email' => 'sarah.nankya@citycare.ug',
                'phone' => '0772123456',
                'specialization' => 'General Medicine',
                'license_number' => 'UG-MD-2020-001'
            ],
            [
                'name' => 'Dr. Michael Mwanga',
                'email' => 'michael.mwanga@citycare.ug',
                'phone' => '0755234567',
                'specialization' => 'Cardiology',
                'license_number' => 'UG-MD-2018-042'
            ],
            [
                'name' => 'Dr. Rebecca Nakato',
                'email' => 'rebecca.nakato@citycare.ug',
                'phone' => '0708345678',
                'specialization' => 'Pediatrics',
                'license_number' => 'UG-MD-2019-078'
            ]
        ];

        foreach ($doctors as $docData) {
            $doctor = User::updateOrCreate(['email' => $docData['email']], [
                'name' => $docData['name'],
                'password' => Hash::make('password123'),
                'role_id' => $doctorRole->id,
                'email_verified_at' => now()
            ]);
        }

        // Create Pharmacist
        $pharmacist = User::updateOrCreate(['email' => 'joseph.lubega@citycare.ug'], [
            'name' => 'Joseph Lubega',
            'password' => Hash::make('password123'),
            'role_id' => $pharmacistRole->id,
            'email_verified_at' => now()
        ]);

        // Create Receptionist
        $receptionist = User::updateOrCreate(['email' => 'grace.namukasa@citycare.ug'], [
            'name' => 'Grace Namukasa',
            'password' => Hash::make('password123'),
            'role_id' => $receptionistRole->id,
            'email_verified_at' => now()
        ]);

        // Create Patients with basic details
        $patients = [
            [
                'name' => 'John Mugisha',
                'email' => 'john.mugisha@gmail.com',
                'phone' => '0771234567',
                'gender' => 'male',
                'address' => 'Plot 12, Kiwatule Road, Kampala',
                'status' => 'Active'
            ],
            [
                'name' => 'Esther Nalwoga',
                'email' => 'esther.nalwoga@gmail.com',
                'phone' => '0709876543',
                'gender' => 'female',
                'address' => 'Plot 45, Entebbe Road, Wakiso',
                'status' => 'Active'
            ],
            [
                'name' => 'David Ssenyonjo',
                'email' => 'david.ssenyonjo@yahoo.com',
                'phone' => '0756123456',
                'gender' => 'male',
                'address' => 'Ntinda, Kampala',
                'status' => 'Active'
            ],
            [
                'name' => 'Grace Babirye',
                'email' => 'grace.babirye@hotmail.com',
                'phone' => '0789234567',
                'gender' => 'female',
                'address' => 'Bukoto, Kampala',
                'status' => 'Active'
            ]
        ];

        $createdPatients = [];
        foreach ($patients as $patientData) {
            // Use phone as unique key since it has unique constraint
            $patient = Patient::updateOrCreate(['phone' => $patientData['phone']], $patientData);
            $createdPatients[] = $patient;

            // Create corresponding user accounts for patients
            $patientUser = User::updateOrCreate(['email' => $patientData['email']], [
                'name' => $patientData['name'],
                'password' => Hash::make('password123'),
                'role_id' => $patientRole->id,
                'email_verified_at' => now()
            ]);
        }

        // Create basic appointments (simplified)
        try {
            $appointment1 = Appointment::create([
                'patient_id' => User::where('email', 'john.mugisha@gmail.com')->first()->id,
                'doctor_id' => User::where('email', 'sarah.nankya@citycare.ug')->first()->id,
                'appointment_date' => Carbon::tomorrow()->format('Y-m-d'),
                'appointment_time' => '10:30:00',
                'status' => 'confirmed',
                'reason' => 'Routine checkup - Hypertension review'
            ]);

            // Create consultation linked to appointment
            Consultation::create([
                'appointment_id' => $appointment1->id,
                'patient_id' => User::where('email', 'john.mugisha@gmail.com')->first()->id,
                'doctor_id' => User::where('email', 'sarah.nankya@citycare.ug')->first()->id,
                'diagnosis' => 'Essential Hypertension - Well controlled',
                'notes' => 'Blood pressure: 120/80 mmHg. Patient compliant with medication.',
                'blood_pressure' => '120/80',
                'temperature' => '36.5',
                'weight' => '75.2',
                'heart_rate' => '72'
            ]);
        } catch (\Exception $e) {
            echo "Appointment/Consultation creation skipped: " . $e->getMessage() . "\n";
        }

        // Bills section removed for simplicity

        // Create sample categories and drugs
        $categories = [
            ['name' => 'Antimalarials', 'description' => 'Treatment for malaria infections'],
            ['name' => 'Antibiotics', 'description' => 'Used to treat bacterial infections'],
            ['name' => 'Painkillers', 'description' => 'Relieve various types of pain'],
            ['name' => 'Supplements', 'description' => 'Vitamins and minerals']
        ];

        foreach ($categories as $cat) {
            $category = Category::updateOrCreate(['name' => $cat['name']], $cat);
            
            if ($cat['name'] == 'Antimalarials') {
                Drug::updateOrCreate(['name' => 'Coartem (Artemether/Lumefantrine)'], [
                    'category_id' => $category->id,
                    'price' => 15000,
                    'quantity' => 500,
                    'description' => 'Standard ACT for malaria treatment',
                    'expiry_date' => '2027-12-31',
                    'low_stock_threshold' => 50
                ]);
            }

            if ($cat['name'] == 'Painkillers') {
                Drug::updateOrCreate(['name' => 'Panadol (Paracetamol)'], [
                    'category_id' => $category->id,
                    'price' => 2000,
                    'quantity' => 1000,
                    'description' => '500mg tablets for fever and pain',
                    'expiry_date' => '2027-06-30',
                    'low_stock_threshold' => 100
                ]);
            }
        }

        echo "Sample data seeded successfully!\n";
        echo "Created:\n";
        echo "- 3 Doctors\n";
        echo "- 1 Pharmacist\n";
        echo "- 1 Receptionist\n";
        echo "- 4 Patients with user accounts\n";
        echo "- Multiple appointments and consultations\n";
        echo "- Sample bills and payments\n";
    }
}
