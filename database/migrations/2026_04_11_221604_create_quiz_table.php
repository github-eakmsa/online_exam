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
        Schema::create('quiz', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('eid');
            $table->integer('subject_ID');
            $table->string('class_level', 10);
            $table->string('title', 100);
            $table->integer('sahi');
            $table->integer('wrong');
            $table->integer('total');
            $table->bigInteger('time');
            $table->text('intro');
            $table->timestamp('date')->useCurrentOnUpdate()->useCurrent();
            $table->integer('status')->default(0);
            $table->integer('result_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz');
    }
};
