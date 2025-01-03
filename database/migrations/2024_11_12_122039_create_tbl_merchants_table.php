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

        Schema::create('tbl_merchants', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('name');
            $table->string('display_picture');
            $table->bigInteger('city_id');
            $table->bigInteger('address');
            $table->bigInteger('contact_person');
            $table->boolean('status');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_merchants');
    }
};
