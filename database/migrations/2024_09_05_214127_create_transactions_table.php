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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onUpdate('cascade')->onDelete('cascade');
            $table->float('amount_invoiced');
            $table->float('amount_paid')->default(0);
            $table->string('description');
            $table->integer('payment_id')->nullable();
            $table->timestamp('date_invoiced')->useCurrent();
            $table->timestamp('date_paid')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('method')->nullable();
            $table->string('payer_ip')->nullable();
            $table->string('hash')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
