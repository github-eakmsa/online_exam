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
        Schema::create('students', function (Blueprint $table) {
            $table->integer('student_ID', true);
            $table->string('profile_ID', 40);
            $table->text('fullname');
            $table->string('col_gender', 6)->nullable();
            $table->integer('col_age')->nullable();
            $table->string('col_phone', 14)->nullable();
            $table->string('col_current_class', 11)->nullable();
            $table->string('col_section', 20)->nullable();
            $table->text('branch');
            $table->integer('record_status')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
