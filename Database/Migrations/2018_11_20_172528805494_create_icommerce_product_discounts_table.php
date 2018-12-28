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
      $table->foreign('product_id')->references('id')->on('icommerce__products')->onDelete('cascade');
  
      $table->integer('product_option_value_id')->unsigned()->nullable();
      $table->foreign('product_option_value_id')->references('id')->on('icommerce__product_option_value')->onDelete('cascade');
  
      $table->integer('product_option_id')->unsigned()->nullable();
      $table->foreign('product_option_id')->references('id')->on('icommerce__product_option')->onDelete('cascade');
      
      $table->integer('quantity')->default(0)->unsigned();
      
      $table->integer('priority')->default(1)->unsigned();
      
      $table->float('discount', 20, 2);
      
      $table->enum('criteria',['percentage','fixed']);
      
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
