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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nameEN');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->enum('type', ['C', 'B', 'F', 'R', 'O'])->default('O'); // C - Cleaning, B - Object, F - Food, R - Restaurant, O - Other
            $table->string('schedule');
            $table->integer('occupation')->nullable();
            $table->string('location')->nullable();
            $table->integer('limit')->nullable();
            $table->string('description');
            $table->string('descriptionEN');
            $table->string('menu_url')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
