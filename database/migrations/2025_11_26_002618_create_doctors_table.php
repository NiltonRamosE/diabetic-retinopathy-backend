<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('cmp', 15)->unique();
            $table->string('specialty', 80);
            $table->foreignId('user_id')->constrained('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctors');
    }
};
