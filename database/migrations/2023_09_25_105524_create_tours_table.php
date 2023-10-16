<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            //Địa điểm diễn ra tour du lịch
            $table->unsignedBigInteger('id_place')->nullable();
            $table->unsignedBigInteger('id_type')->nullable();
            //Tiêu đề
            $table->string('title')->unique();
            // Slug SEO
            $table->string('slug');
            //Hình ảnh tour
            $table->string('image')->nullable();
            //Mô tả ngắn gọn địa điểm chuyến đi diễn ra
            $table->string('des_address')->nullable();
            // Ngày bắt đầu
            $table->dateTime('star_date_tour');
            //Ngày kết thúc
            $table->dateTime('end_date_tour');
            //Số ngày diễn ra trong chuyến đi
            $table->smallInteger('total_date_tour');
            //Giá dự kiến cho 1 người
            $table->decimal('normal_prices', 12, 3);
            //Số lượng người trong 1 chuyến đi
            $table->smallInteger('quantity')->default(0);
            //Thông tin mô tar chuyêến đi
            $table->longText('information')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('id_place')->references('id')->on('places')->cascadeOnDelete();
            $table->foreign('id_type')->references('id')->on('types')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours');
    }
}
