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

        Schema::create('tbl_merchant_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('merchant_id');
            $table->foreign('merchant_id')->references('id')->on('tbl_merchants');
            $table->bigInteger('order_id');
            $table->decimal('amount');
            $table->timestamp('payment_date');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_merchant_payments');
    }
};
