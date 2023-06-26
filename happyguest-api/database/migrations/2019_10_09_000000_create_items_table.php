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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('price')->nullable();
            $table->enum('type', ['O', 'F']); // O - Object, F - Food
            $table->enum('category', ['room', 'bathroom', 'drink', 'breakfast', 'lunch', 'dinner', 'snack', 'other']);
            $table->integer('amount_stock')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    // Object: Room, Bathroom, Other
    // Food: Drink, Breakfast, Lunch, Dinner, Snack, Other

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
