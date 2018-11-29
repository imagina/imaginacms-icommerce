<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceManufacturerTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__manufacturer_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your translatable fields
      
      $table->string('name');
      $table->integer('manufacturer_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['manufacturer_id', 'locale']);
      $table->foreign('manufacturer_id')->references('id')->on('icommerce__manufacturers')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__manufacturer_translations', function (Blueprint $table) {
      $table->dropForeign(['manufacturer_id']);
    });
    Schema::dropIfExists('icommerce__manufacturer_translations');
  }
}
