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
        Schema::create('login_information', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('profileID', 100)->unique('profileid');
            $table->string('username', 70)->unique('username');
            $table->string('password', 250);
            $table->text('temp');
            $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_information');
    }
};
