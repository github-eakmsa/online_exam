<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            // Primary key (sn)
            $table->increments('sn');

            // Business identifier
            $table->text('userid');

            // Profile fields
            $table->text('fullname');
            $table->text('phone');
            $table->text('branch');
            $table->text('role');

            // Status (0 = inactive, 1 = active)
            $table->integer('status')->default(1);

            // No timestamps (IMPORTANT)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};