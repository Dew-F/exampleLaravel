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
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->string('uid', 50)->primary();
            $table->string('name');
            $table->string('attribute_uid');
            $table->foreign('attribute_uid')->references('uid')->on('attributes')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('active')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_values');
    }
};
