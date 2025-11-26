<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->timestamp('report_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('comments', 500);
            $table->foreignId('image_id')->constrained('images');
            $table->foreignId('diagnosis_id')->constrained('diagnoses');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
};
