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
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->string('user_code');
            $table->foreign('user_code')->references('user_code')->on('users');
            $table->foreignId('leave_type_id')->constrained('leave_types');
            $table->year('year');
            $table->integer('opening_balance')->default(0);
            $table->integer('accrued')->default(0);
            $table->integer('used')->default(0);
            $table->integer('adjusted')->default(0);
            $table->integer('remaining')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
