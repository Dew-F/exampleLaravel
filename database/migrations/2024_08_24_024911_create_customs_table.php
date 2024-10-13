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
        Schema::create('customs', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('text')->nullable();
            $table->timestamp('date')->useCurrent();
            $table->foreignId('manager_id')->nullable()->constrained('managers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('product_uid')->nullable();
            $table->foreign('product_uid')->references('uid')->on('products')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customs');
    }
};
