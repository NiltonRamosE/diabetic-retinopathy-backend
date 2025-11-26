<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('reason', 200);
            $table->string('status', 50);
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
