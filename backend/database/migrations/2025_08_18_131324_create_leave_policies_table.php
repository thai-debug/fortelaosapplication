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
        Schema::create('leave_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leave_type_id')->constrained('leave_types')->onDelete('cascade');
            $table->foreignId('employment_type_id')->constrained('employment_types')->onDelete('cascade');
            $table->string('entitlement_day')->nullable();
            $table->string('accrual_method')->nullable();
            $table->string('carryover_max')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_policies');
    }
};
