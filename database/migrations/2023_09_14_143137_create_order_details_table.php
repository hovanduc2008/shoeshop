<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

        Schema::create('order_details', function (Blueprint $table) {
            $table -> id();
            $table -> unsignedBigInteger('product_id');
            $table -> unsignedBigInteger('order_id');
            $table -> bigInteger('quantity');
            $table -> string('size');
            $table -> string('color_code');
            $table -> bigInteger('item_price');
            $table->softDeletes();
            $table -> timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('order_id')->references('id')->on('orders');
        });

        DB::unprepared('
            CREATE TRIGGER decrease_product_quantity AFTER INSERT ON order_details
            FOR EACH ROW
            BEGIN
                UPDATE products SET quantity = quantity - NEW.quantity WHERE id = NEW.product_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
