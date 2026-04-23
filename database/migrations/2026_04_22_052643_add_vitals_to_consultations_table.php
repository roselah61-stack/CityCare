<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->string('blood_pressure')->nullable();
            $table->string('temperature')->nullable();
            $table->string('weight')->nullable();
            $table->string('heart_rate')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn(['blood_pressure', 'temperature', 'weight', 'heart_rate']);
        });
    }
};
