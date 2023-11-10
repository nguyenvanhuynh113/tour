<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupon_tours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_coupon')->nullable();
            $table->unsignedBigInteger('id_tour')->nullable();
            $table->foreign('id_coupon')->references('id')->on('coupons')->cascadeOnDelete();
            $table->foreign('id_tour')->references('id')->on('tours')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_tours');
    }
};
