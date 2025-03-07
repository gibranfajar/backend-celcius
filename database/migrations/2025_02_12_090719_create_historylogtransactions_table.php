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
        Schema::create('historylogtransactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->string('user');
            $table->string('product');
            $table->integer('price');
            $table->integer('qty');
            $table->string('size');
            $table->string('color');
            $table->string('courier');
            $table->string('service');
            $table->integer('service_ongkir');
            $table->integer('ongkir');
            $table->integer('discount');
            $table->string('voucher')->nullable();
            $table->string('status_payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historylogtransactions');
    }
};
