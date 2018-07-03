<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceAddressesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__addresses', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->integer('user_id')->unsigned()->nullable();
      $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
      $table->string('firstname');
      $table->string('lastname');
      $table->string('company')->nullable();
      $table->text('address_1');
      $table->text('address_2')->nullable();
      $table->string('city');
      $table->string('postcode');
      $table->string('country');
      $table->string('zone')->nullable();
      
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
    Schema::dropIfExists('icommerce__addresses');
  }
}
