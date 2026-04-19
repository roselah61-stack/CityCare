<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('treatments', function (Blueprint $table) {

        $table->unsignedBigInteger('patient_id')->after('id');
        $table->unsignedBigInteger('drug_id')->after('patient_id');

        $table->text('details')->nullable();
        $table->date('treatment_date')->nullable();

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
