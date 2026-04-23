<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drug_inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drug_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->string('type'); // stock_in, stock_out
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // who performed the action
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drug_inventory_logs');
    }
};
