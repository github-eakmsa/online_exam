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
        Schema::create('login_information_tmp', function (Blueprint $table) {
            $table->integer('id');
            $table->string('profileID', 100);
            $table->string('username', 70);
            $table->string('password', 50);
            $table->text('temp');
            $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_information_tmp');
    }
};
