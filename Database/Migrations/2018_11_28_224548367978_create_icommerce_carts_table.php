<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceCartsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__carts', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      
      // Your fields
      $table->integer('user_id')->unsigned()->nullable();
      $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
      $table->string('ip')->nullable();
      $table->tinyInteger('status')->default(1)->unsigned();
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
    Schema::dropIfExists('icommerce__carts');
  }
}
