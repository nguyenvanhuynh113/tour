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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();
            // mã giao dịch
            $table->string('transaction_no')->unique();
            // mã ngân hàng
            $table->string('bank_code');
            // số tiền thanh toán
            $table->decimal('amount', 10, 2);
            // loại tài khoản / thẻ khách hàng sử dụng (_ATM / Chuyển khoản_)
            $table->string('card_type')->nullable();
            // thông tin thanh toán VD: thanh toán hóa đơn
            $table->string('order_info')->nullable();
            // trạng thái thanh toán
            $table->boolean('status')->default(1);
            $table->softDeletes();
            $table->foreign('id_user')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
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
