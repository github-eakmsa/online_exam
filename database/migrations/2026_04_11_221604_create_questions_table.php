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
        Schema::create('questions', function (Blueprint $table) {
            $table->integer('sn', true);
            $table->text('qid');
            $table->integer('grade_level');
            $table->text('subject');
            $table->text('qns');
            $table->integer('choice');
            $table->text('created_by');
            $table->timestamp('created_date')->useCurrentOnUpdate()->useCurrent();
            $table->string('exam_type', 30);
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
