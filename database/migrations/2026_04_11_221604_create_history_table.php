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
        Schema::create('history', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('profileID', 50);
            $table->text('eid');
            $table->integer('correct');
            $table->integer('wrong');
            $table->integer('unanswered');
            $table->integer('score');
            $table->integer('level');
            $table->timestamp('date')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history');
    }
};
