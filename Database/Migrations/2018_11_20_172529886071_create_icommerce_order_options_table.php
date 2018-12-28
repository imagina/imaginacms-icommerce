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
  
      //-- ProductOptionValue values
      $table->string('parent_option_value')->nullable();
      $table->string('option_value')->nullable();
      $table->integer('quantity')->nullable();
      $table->tinyInteger('subtract')->unsigned()->nullable();
      $table->float('price', 50, 2)->nullable();
      $table->string('price_prefix')->nullable();
      $table->integer('points')->unsigned()->nullable();
      $table->string('points_prefix')->nullable();
      $table->float('weight', 8, 2)->nullable();
      $table->string('weight_prefix')->nullable();
  
      //-- productOption values
      $table->string('value')->nullable();
      $table->integer('required')->unsigned()->nullable();

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
