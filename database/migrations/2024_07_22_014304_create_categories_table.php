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
        Schema::create('categories', function (Blueprint $table) {
            $table->string('uid', 50)->primary();
            $table->string('name');
            $table->string('slug');
            $table->string('parent_uid')->nullable();
            $table->foreign('parent_uid')->references('uid')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('category_type_id')->constrained('category_types')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('active')->default(0);
            $table->integer('sort')->default(1000);
            $table->text('category_footer_title')->nullable();
            $table->longText('category_footer_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
