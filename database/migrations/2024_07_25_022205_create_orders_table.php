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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->boolean('order_status');
            $table->boolean('pay_status');
            $table->string('full_name');
            $table->string('telephone');
            $table->string('email');
            $table->float('total', 20);
            $table->foreignId('manager_id')->nullable()->constrained('managers')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
