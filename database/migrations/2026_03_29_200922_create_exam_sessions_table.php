<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_sessions', function (Blueprint $table) {

            $table->id();

            // Link to student
            $table->string('profileID');

            // Exam business ID (eid)
            $table->string('exam_id');

            // Timing
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();

            // Status: 1 = active, 0 = completed
            $table->integer('status')->default(1);

            // Optional (recommended)
            $table->string('ip_address')->nullable();

            // Indexes for performance
            $table->index(['profileID', 'exam_id']);
            $table->unique(['profileID', 'exam_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_sessions');
    }
};