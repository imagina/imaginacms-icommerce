<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceOrderOptionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__order_options', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields
      $table->integer('order_id')->unsigned();
      $table->foreign('order_id')->references('id')->on('icommerce__orders')->onDelete('restrict');
      
      $table->integer('order_product_id')->unsigned();
      $table->foreign('order_product_id')->references('id')->on('icommerce__order_product')->onDelete('restrict');
      
      $table->integer('product_option_id')->unsigned();
      $table->foreign('product_option_id')->references('id')->on('icommerce__product_option')->onDelete('restrict');
      
      $table->integer('product_option_value_id')->unsigned();
      $table->foreign('product_option_value_id')->references('id')->on('icommerce__product_option_values')->onDelete('restrict');
      
      $table->string('name');
      $table->text('value');
      $table->string('type');
      $table->text('options')->default('')->nullable();
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
    Schema::dropIfExists('icommerce__order_options');
  }
}
