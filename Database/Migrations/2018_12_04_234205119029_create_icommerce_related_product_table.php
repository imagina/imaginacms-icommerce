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
        Schema::create('icommerce__related_product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('icommerce__products')->onDelete('restrict');

            $table->integer('related_id')->unsigned()->nullable();
            $table->foreign('related_id')->references('id')->on('icommerce__products')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('icommerce__related_product');
    }
};
