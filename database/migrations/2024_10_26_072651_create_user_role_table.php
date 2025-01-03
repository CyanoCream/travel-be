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
        Schema::disableForeignKeyConstraints();

        Schema::create('user_role', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('role_code');
            $table->foreign('role_code')->references('code')->on('role');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_role');
    }
};
