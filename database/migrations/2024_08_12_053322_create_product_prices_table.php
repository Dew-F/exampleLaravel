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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->string('product_uid');
            $table->foreign('product_uid')->references('uid')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->string('price_uid');
            $table->foreign('price_uid')->references('uid')->on('prices')->onUpdate('cascade')->onDelete('cascade');
            $table->float('price');
            $table->unique(array('product_uid', 'price_uid'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
