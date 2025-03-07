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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('image');
            $table->string('category');
            $table->string('banner_left');
            $table->string('banner_right');
            $table->string('banner_center');
            $table->foreignId('product1_id')->references('id')->on('products');
            $table->foreignId('product2_id')->references('id')->on('products');
            $table->foreignId('product3_id')->references('id')->on('products');
            $table->foreignId('product4_id')->references('id')->on('products');
            $table->foreignId('product5_id')->references('id')->on('products');
            $table->foreignId('product6_id')->references('id')->on('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
