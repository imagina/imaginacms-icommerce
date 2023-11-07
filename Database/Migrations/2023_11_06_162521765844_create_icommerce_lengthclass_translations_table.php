<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceLengthClassTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__length_class_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('title');
      $table->string('unit');
      // Your translatable fields
      
      $table->integer('length_class_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['length_class_id', 'locale']);
      $table->foreign('length_class_id')->references('id')->on('icommerce__length_classes')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__length_class_translations', function (Blueprint $table) {
      $table->dropForeign(['length_class_id']);
    });
    Schema::dropIfExists('icommerce__length_class_translations');
  }
}
