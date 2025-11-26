<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('file_name', 200);
            $table->string('path', 400);
            $table->timestamp('uploaded_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('resolution', 50)->nullable();
            $table->foreignId('doctor_id')->constrained('doctors');
            $table->foreignId('category_id')->constrained('categories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
};
