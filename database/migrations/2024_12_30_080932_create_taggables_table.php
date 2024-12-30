<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('taggables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->constrained()->onDelete('cascade'); // Relasi ke tags
            $table->morphs('taggable'); // Kolom `taggable_id` dan `taggable_type`
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taggables');
    }
};
