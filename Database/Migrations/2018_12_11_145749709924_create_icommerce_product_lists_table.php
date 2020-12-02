<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceProductListsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__product_lists', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields
      $table->integer('product_id')->unsigned();
      $table->foreign('product_id')->references('id')->on('icommerce__products')->onDelete('restrict');
  
      $table->integer('price_list_id')->unsigned();
      $table->foreign('price_list_id')->references('id')->on('icommerce__price_lists')->onDelete('restrict');
      
      $table->decimal('price',20,2);
      
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
    Schema::dropIfExists('icommerce__product_lists');
  }
}
