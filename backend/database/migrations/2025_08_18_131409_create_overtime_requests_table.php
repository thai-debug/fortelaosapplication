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
        Schema::create('overtime_requests', function (Blueprint $table) {
            $table->id();
          $table->string('request_user_code');
            $table->foreign('request_user_code')->references('user_code')->on('users')->onDelete('cascade');
            $table->date('date');
            $table->time('hours'); // Or use decimal if storing hours as float
            $table->string('reason');
            $table->string('status');
            $table->dateTime('submitted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtime_requests');
    }
};
