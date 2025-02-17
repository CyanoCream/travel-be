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
        Schema::create('travel_schedule', function (Blueprint $table) {
            $table->id();
            $table->string('destination');
            $table->date('departure_date');
            $table->dateTime('departure_time');
            $table->integer('passenger_quota');
            $table->decimal('ticket_price', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_schedule');
    }
};
