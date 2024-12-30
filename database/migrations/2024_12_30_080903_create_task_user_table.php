<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('task_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade'); // Relasi ke tasks
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke users
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_user');
    }
};
