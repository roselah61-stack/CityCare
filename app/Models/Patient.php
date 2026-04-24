<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Bill;
use App\Models\LabResult;

class Patient extends Model
{
    //
    protected $fillable = [
    'name',
    'phone',
    'email',
    'gender',
    'address',
    'status'
];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function labResults()
    {
        return $this->hasMany(LabResult::class);
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }
}
