<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceProductOptionValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__product_option_values', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields

            $table->integer('product_option_id')->unsigned();
            $table->foreign('product_option_id')->references('id')->on('icommerce__product_option')->onDelete('restrict');

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('icommerce__products')->onDelete('restrict');

            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('icommerce__options')->onDelete('restrict');

            $table->integer('option_value_id')->unsigned();
            $table->foreign('option_value_id')->references('id')->on('icommerce__option_values')->onDelete('restrict');

            $table->integer('quantity')->unsigned();
            $table->tinyInteger('substract')->unsigned();
            $table->float('price', 8, 2);
            $table->string('price_prefix');
            $table->integer('points')->unsigned();
            $table->string('points_prefix');
            $table->float('weight', 8, 2);
            $table->string('weight_prefix');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('icommerce__product_option_values');
    }
}
