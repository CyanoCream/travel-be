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

        Schema::create('tbl_sales_reports', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('merchant_id');
            $table->foreign('merchant_id')->references('id')->on('tbl_merchants');
            $table->bigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('tbl_products');
            $table->decimal('total_sales');
            $table->bigInteger('sales_quantity');
            $table->date('report_month');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_sales_reports');
    }
};
