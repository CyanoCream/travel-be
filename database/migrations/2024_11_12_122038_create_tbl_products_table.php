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

        Schema::create('tbl_products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->bigInteger('merchan_id');
            $table->string('type');
            $table->decimal('price');
            $table->bigInteger('stock');
            $table->bigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('tbl_product_categories');
            $table->string('description');
            $table->boolean('status');
            $table->string('slug')->unique()->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_products');
    }
};
