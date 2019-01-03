<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceCartProductOptionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__cart_product_options', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      
      // Your fields
      $table->integer('cart_product_id')->unsigned();
      $table->foreign('cart_product_id')->references('id')->on('icommerce__cart_product')->onDelete('restrict');
  
      $table->integer('product_option_id')->unsigned()->nullable();
      $table->foreign('product_option_id')->references('id')->on('icommerce__product_option')->onDelete('restrict');
  
  
      $table->integer('product_option_value_id')->unsigned()->nullable();
      $table->foreign('product_option_value_id')->references('id')->on('icommerce__product_option_value')->onDelete('restrict');
      
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
    Schema::dropIfExists('icommerce__cart_product_options');
  }
}
