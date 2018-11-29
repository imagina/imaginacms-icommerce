<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceProductTagTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__product_tag', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields
      $table->integer('product_id')->unsigned();
      $table->foreign('product_id')->references('id')->on('icommerce__products')->onDelete('restrict');
      $table->integer('tag_id')->unsigned();
      $table->foreign('tag_id')->references('id')->on('icommerce__tags')->onDelete('restrict');
      
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
    Schema::dropIfExists('icommerce__product_tag');
  }
}
