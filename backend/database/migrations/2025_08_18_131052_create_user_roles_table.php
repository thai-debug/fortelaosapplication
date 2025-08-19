<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('user_code');
            $table->foreign('user_code')->references('user_code')->on('users')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->unique(['user_code', 'role_id']); // Prevent duplicates
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
