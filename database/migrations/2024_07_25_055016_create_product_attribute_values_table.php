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
        Schema::create('product_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->string('product_uid');
            $table->foreign('product_uid')->references('uid')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->string('attribute_value_uid');
            $table->foreign('attribute_value_uid')->references('uid')->on('attribute_values')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('active')->default(0);
            $table->unique(['product_uid', 'attribute_value_uid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attribute_values');
    }
};
