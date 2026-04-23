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
        // Only add constraints if tables exist
        if (Schema::hasTable('patients')) {
            Schema::table('patients', function (Blueprint $table) {
                // Add unique constraints for patients
                if (!Schema::hasColumn('patients', 'phone') || !$this->hasIndex('patients', 'patients_phone_unique')) {
                    $table->unique('phone', 'patients_phone_unique');
                }
                if (!Schema::hasColumn('patients', 'email') || !$this->hasIndex('patients', 'patients_email_unique')) {
                    $table->unique('email', 'patients_email_unique');
                }
            });
        }

        if (Schema::hasTable('drugs')) {
            Schema::table('drugs', function (Blueprint $table) {
                // Add unique constraint for drugs (case-insensitive)
                if (!Schema::hasColumn('drugs', 'name') || !$this->hasIndex('drugs', 'drugs_name_unique')) {
                    $table->unique('name', 'drugs_name_unique');
                }
            });
        }

        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                // Add unique constraint for categories (case-insensitive)
                if (!Schema::hasColumn('categories', 'name') || !$this->hasIndex('categories', 'categories_name_unique')) {
                    $table->unique('name', 'categories_name_unique');
                }
            });
        }

        // Users table already has email unique constraint from creation migration
    }

    /**
     * Check if index exists
     */
    private function hasIndex(string $table, string $index): bool
    {
        $indexes = Schema::getIndexListing($table);
        return collect($indexes)->contains('name', $index);
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

        // Users table email constraint is handled by original users migration
    }
};
