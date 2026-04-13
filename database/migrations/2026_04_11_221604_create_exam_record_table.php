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
        Schema::create('exam_record', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('std_id', 500);
            $table->string('exam_id', 500);
            $table->string('Question_id', 500);
            $table->string('option_id', 500);
            $table->timestamp('time')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_record');
    }
};
