<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Consultation extends Model
{
    protected $fillable = [
        'appointment_id',
        'doctor_id',
        'patient_id',
        'chief_complaint',
        'history_of_present_illness',
        'past_medical_history',
        'family_history',
        'social_history',
        'allergies',
        'medications',
        'physical_examination',
        'vital_signs',
        'diagnosis',
        'differential_diagnosis',
        'investigations_ordered',
        'investigation_results',
        'treatment_plan',
        'medications_prescribed',
        'follow_up_plan',
        'notes',
        'blood_pressure',
        'temperature',
        'weight',
        'height',
        'heart_rate',
        'respiratory_rate',
        'oxygen_saturation',
        'bmi'
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function prescription(): HasOne
    {
        return $this->hasOne(Prescription::class);
    }
}
