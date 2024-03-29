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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['C', 'E', 'M', 'A'])->default('C'); // C = Client, E = Employee, M = Manager, A = Admin
            $table->string('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->boolean('blocked')->default(false);
            $table->string('photo_url')->nullable();
            $table->date('last_review')->nullable();
            $table->string('fcm_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['email', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
