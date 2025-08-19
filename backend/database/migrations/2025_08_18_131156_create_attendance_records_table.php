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
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->string('user_code'); // Using user_code instead of user_id
            $table->foreign('user_code')->references('user_code')->on('users')->onDelete('cascade');
            $table->date('work_date');
            $table->time('morning_check_in')->nullable();
            $table->time('morning_check_out')->nullable();
            $table->time('afternoon_check_in')->nullable();
            $table->time('evening_check_out')->nullable();
            $table->string('import_file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->unique(['user_code', 'work_date']); // One record per user per day
            $table->dateTime('submitted_at');
            $table->timestamps();

            // Composite index for better query performance
            //$table->index(['user_code', 'work_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
