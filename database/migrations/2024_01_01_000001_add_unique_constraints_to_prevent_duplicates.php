<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Add unique constraints for patients
            $table->unique('phone', 'patients_phone_unique');
            $table->unique('email', 'patients_email_unique');
        });

        Schema::table('drugs', function (Blueprint $table) {
            // Add unique constraint for drugs (case-insensitive)
            $table->unique('name', 'drugs_name_unique');
        });

        Schema::table('categories', function (Blueprint $table) {
            // Add unique constraint for categories (case-insensitive)
            $table->unique('name', 'categories_name_unique');
        });

        Schema::table('users', function (Blueprint $table) {
            // Add unique constraints for users
            $table->unique('email', 'users_email_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropUnique('patients_phone_unique');
            $table->dropUnique('patients_email_unique');
        });

        Schema::table('drugs', function (Blueprint $table) {
            $table->dropUnique('drugs_name_unique');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique('categories_name_unique');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
        });
    }
};
