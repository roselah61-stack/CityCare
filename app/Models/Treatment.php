<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = [
    'patient_id',
    'drug_id',
    'details',
    'treatment_date',
];
    //
    public function up()
{
    Schema::create('treatments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->constrained()->onDelete('cascade');
        $table->foreignId('drug_id')->constrained()->onDelete('cascade');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}
public function patient()
{
    return $this->belongsTo(Patient::class);
}

public function drug()
{
    return $this->belongsTo(Drug::class);
}
}
