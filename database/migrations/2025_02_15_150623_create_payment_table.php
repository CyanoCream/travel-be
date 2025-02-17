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
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_booking_id')->constrained('ticket_booking')->onDelete('cascade');
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('payment_proof')->nullable();
            $table->enum('payment_status', ['PENDING', 'PAID', 'FAILED'])->default('pending');
            $table->string('payment_code')->unique();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
