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
        Schema::create('overtime_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('approver_user_code');
            $table->foreign('approver_user_code')->references('user_code')->on('users')->onDelete('cascade');
            $table->foreignId('overtime_request_id')->constrained('overtime_requests')->onDelete('cascade');
            $table->string('action');
            $table->text('comment')->nullable();
            $table->dateTime('submitted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtime_approvals');
    }
};
