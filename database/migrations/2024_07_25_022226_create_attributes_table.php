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
        Schema::create('attributes', function (Blueprint $table) {
            $table->string('uid', 50)->primary();
            $table->string('name');
            $table->string('category_uid')->nullable();
            $table->foreign('category_uid')->references('uid')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('active')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
