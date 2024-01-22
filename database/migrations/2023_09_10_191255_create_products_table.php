<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('added_by'); 
            $table->string('title');
            $table->string('slug');
            $table->string('image') -> default('');
            $table->string('thumbnail');
            $table->unsignedBigInteger('category_id'); 
            $table->bigInteger('price');
            $table->bigInteger('quantity');
            $table->text('description') -> nullable();
            $table->text('content') -> nullable();
            $table->string('meta_title') -> nullable();
            $table->text('meta_description') -> nullable();
            $table->enum('status', [0, 1]) -> default(1);
            $table->enum('hot', [0, 1]) -> default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('added_by')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
