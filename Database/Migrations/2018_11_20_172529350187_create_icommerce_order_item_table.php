<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('icommerce__order_item', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('icommerce__orders')->onDelete('restrict');

            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('icommerce__products')->onDelete('restrict');

            $table->integer('item_type_id')->unsigned()->nullable();
            $table->foreign('item_type_id')->references('id')->on('icommerce__item_types')->onDelete('restrict');

            $table->text('title');
            $table->string('reference')->nullable();
            $table->integer('quantity')->unsigned();
            $table->float('price', 30, 2);
            $table->float('total', 30, 2);
            $table->float('tax', 30, 2);
            $table->integer('reward')->unsigned();
            $table->text('options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('icommerce__order_item');
    }
};
