<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tour')->nullable();
            //Mã CODE đặt vé
            $table->string('booking_number')->unique();
            //Thông tin khách hàng đặt
            $table->string('customer_name')->nullable();
            $table->string('email');
            $table->string('phone_number')->nullable();
            //Ngày đặt vé
            $table->date('booking_date')->nullable();
            //Ngày khởi hành
            $table->date('departure_date')->nullable();
            //Số lượng trẻ em
            $table->smallInteger('child')->default(0)->nullable();
            //Số lượng người lớn
            $table->smallInteger('person')->default(0)->nullable();
            //Tổng tiền đươn đặt vé chuyến đi
            $table->decimal('total_prices', 12, 3)->nullable();
            $table->timestamps();
            $table->foreign('id_tour')->references('id')->on('tours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
