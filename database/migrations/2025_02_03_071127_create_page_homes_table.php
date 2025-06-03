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
        Schema::create('page_homes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('bannertop_desktop_image');
            $table->string('bannertop_mobile_image');
            $table->string('bannerbottom_desktop_image');
            $table->string('bannerbottom_mobile_image');
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_homes');
    }
};
