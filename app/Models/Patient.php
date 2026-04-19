<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    public function up()
{
    Schema::create('patients', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->nullable();
        $table->string('phone');
        $table->timestamps();
    });
}
public function treatments()
{
    return $this->hasMany(Treatment::class);
}
}
