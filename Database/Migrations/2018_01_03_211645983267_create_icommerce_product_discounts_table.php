<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceProductDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__product_discounts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields

            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('icommerce__products')->onDelete('restrict');

            $table->integer('quantity')->default(0)->unsigned();
            $table->integer('priority')->default(1)->unsigned();
            $table->float('price', 8, 2)->default(0);

            $table->date('date_start');
            $table->date('date_end');

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
        Schema::dropIfExists('icommerce__product_discounts');
    }
}
