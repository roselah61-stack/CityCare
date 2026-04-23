<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function appointments()
    {
        return $this->appointmentsAsDoctor();
    }

    public function appointmentsAsPatient()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function appointmentsAsDoctor()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function consultationsAsPatient()
    {
        return $this->hasMany(Consultation::class, 'patient_id');
    }

    public function consultationsAsDoctor()
    {
        return $this->hasMany(Consultation::class, 'doctor_id');
    }

    public function prescriptionsAsPatient()
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }

    public function prescriptionsAsDoctor()
    {
        return $this->hasMany(Prescription::class, 'doctor_id');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function billsAsCashier()
    {
        return $this->hasMany(Bill::class, 'cashier_id');
    }
}