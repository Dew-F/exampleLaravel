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
        Schema::create('products', function (Blueprint $table) {
            $table->string('uid', 50)->primary();
            $table->string('name');
            $table->string('slug');
            $table->float('price');
            $table->string('description', 10000)->nullable();
            $table->string('article');
            $table->string('availability');
            $table->string('category_uid');
            $table->foreign('category_uid')->references('uid')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('video')->nullable();
            $table->foreignId('category_type_id')->constrained('category_types')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('active');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
