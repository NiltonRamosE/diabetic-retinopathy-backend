<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->string('description', 500);
            $table->timestamp('diagnosis_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreignId('history_id')->constrained('medical_histories');
            $table->foreignId('doctor_id')->constrained('doctors');
        });
    }

    public function down()
    {
        Schema::dropIfExists('diagnoses');
    }
};
