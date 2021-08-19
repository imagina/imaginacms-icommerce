<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceCartProductTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__cart_product', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      
      // Your fields
      $table->integer('cart_id')->unsigned()->nullable();
      $table->foreign('cart_id')->references('id')->on('icommerce__carts')->onDelete('cascade');
      
      $table->integer('product_id')->unsigned();
      $table->foreign('product_id')->references('id')->on('icommerce__products')->onDelete('cascade');
      
      $table->integer('quantity')->default(1);
      $table->text('options')->nullable();
      
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
    Schema::dropIfExists('icommerce__cart_product');
  }
}
