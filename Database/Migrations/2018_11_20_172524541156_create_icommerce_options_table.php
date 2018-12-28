<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceOptionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__options', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields
      $table->string('type');
      $table->integer('sort_order')->default(0);
  
      $table->integer('parent_id')->unsigned();
      $table->foreign('parent_id')
        ->references('id')
        ->on('icommerce__options')
        ->onDelete('restrict');
  
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
    Schema::dropIfExists('icommerce__options');
  }
}
