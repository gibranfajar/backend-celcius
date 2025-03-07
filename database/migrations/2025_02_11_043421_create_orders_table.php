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
            $table->string('invoice');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('voucher_id')->nullable();
            $table->integer('weight');
            $table->string('courier');
            $table->string('service');
            $table->integer('service_ongkir');
            $table->integer('ongkir');
            $table->integer('discount');
            $table->integer('total');
            $table->integer('gross_amount');
            $table->string('status');
            $table->string('status_payment');
            $table->string('resi')->nullable();
            $table->string('payment_token')->nullable();
            $table->string('payment_url')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
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
