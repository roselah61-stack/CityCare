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
        // This migration is kept for deployment compatibility
        // All constraints are now handled by the 2026_04_23_000001 migration
        // This migration does nothing to prevent conflicts
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Do nothing - constraints are handled by the newer migration
    }
};
