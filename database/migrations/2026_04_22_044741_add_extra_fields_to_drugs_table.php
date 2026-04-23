<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->date('expiry_date')->nullable();
            $table->integer('low_stock_threshold')->default(10);
        });
    }

    public function down(): void
    {
        Schema::table('drugs', function (Blueprint $table) {
            $table->dropColumn(['expiry_date', 'low_stock_threshold']);
        });
    }
};
