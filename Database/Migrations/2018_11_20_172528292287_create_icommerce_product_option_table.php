<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceProductOptionTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__product_option', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields
      $table->integer('product_id')->unsigned();
      $table->foreign('product_id')->references('id')->on('icommerce__products')->onDelete('cascade');
      
      $table->integer('option_id')->unsigned();
      $table->foreign('option_id')->references('id')->on('icommerce__options')->onDelete('cascade');
  
      $table->integer('parent_id')->unsigned()->nullable();
      $table->foreign('parent_id')
        ->references('id')
        ->on('icommerce__options')
        ->onDelete('restrict');
  
      $table->integer('parent_option_value_id')->unsigned()->nullable();
      $table->foreign('parent_option_value_id')
        ->references('id')
        ->on('icommerce__option_values')
        ->onDelete('restrict');
      
      $table->string('value');
      $table->integer('required')->unsigned();
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
    Schema::dropIfExists('icommerce__product_option');
  }
}
