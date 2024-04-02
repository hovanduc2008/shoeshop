<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table -> id();
            $table -> unsignedBigInteger('user_id');
            $table -> string('order_title') -> nulable();
            $table -> string('shipping_address');
            $table -> string('email');
            $table -> string('phone_number');
            $table -> string('full_name');
            $table -> bigInteger('total_amount');
            $table -> string('payment_method') -> nulable();
            $table -> enum('payment_status', [0, 1]) -> default(0) -> nulable();
            $table -> enum('order_status', [0, 1, 2]) -> default(0) -> nulable();
            $table -> string('order_code') -> nulable();
            $table -> string('order_note') -> nulable();
            $table -> string('vnp_TransactionStatus') -> default('02');
            $table -> string('province') -> nulable();
            $table -> string('district') -> nulable();
            $table -> string('commune') -> nulable();
            $table -> datetime('successfully_delivery_at');
            $table->softDeletes();
            $table -> timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
