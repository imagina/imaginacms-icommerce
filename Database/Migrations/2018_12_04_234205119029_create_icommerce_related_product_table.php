<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceRelatedProductTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
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
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('icommerce__related_product');
  }
}
