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
        Schema::create('payments_received', function (Blueprint $table) {
            $table->id();
            $table->string('merchant');
            $table->foreignId('order_id')->constrained('orders')->onUpdate('cascade')->onDelete('cascade');
            $table->float('amount_paid');
            $table->string('description');
            $table->integer('payment_id');
            $table->timestamp('date_paid')->nullable();
            $table->string('payer_id');
            $table->string('method');
            $table->string('payer_ip');
            $table->string('hash');
            $table->string('errors')->nullable();
            $table->timestamp('date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments_received');
    }
};
