<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceCategoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__categories', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields
      
      $table->text('options')->nullable();
  
      $table->integer('parent_id')->default(0);
      $table->integer('lft')->unsigned()->nullable();
      $table->integer('rgt')->unsigned()->nullable();
      $table->integer('depth')->unsigned()->nullable();
      
      $table->tinyInteger('show_menu')->default(0)->unsigned();
      
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
    Schema::dropIfExists('icommerce__categories');
  }
}
