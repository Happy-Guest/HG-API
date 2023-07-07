<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotel', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->string('website')->nullable();
            $table->integer('capacity')->nullable();
            $table->string('policies')->nullable();
            $table->string('access')->nullable();
            $table->string('comodities')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel');
    }
};
