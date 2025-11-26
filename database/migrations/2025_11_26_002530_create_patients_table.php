<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->date('birth_date');
            $table->char('dni', 8)->unique();
            $table->foreignId('user_id')->constrained('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
