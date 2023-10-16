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
        Schema::create('departure_dates', function (Blueprint $table) {
            $table->id();
            //Giá vé theo ngày xuất phát
            $table->decimal('prices', 12, 3);
            //Ngày xuất phát
            $table->date('departure_date');
            $table->smallInteger('quantity')->nullable();
            $table->unsignedBigInteger('id_tour')->nullable();
            $table->timestamps();
            $table->foreign('id_tour')->references('id')->on('tours')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departure_dates');
    }
};
