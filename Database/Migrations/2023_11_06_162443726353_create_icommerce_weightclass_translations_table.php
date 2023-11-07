<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceWeightClassTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__weight_class_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('title');
      $table->string('unit');
      // Your translatable fields
      
      $table->integer('weight_class_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['weight_class_id', 'locale']);
      $table->foreign('weight_class_id')->references('id')->on('icommerce__weight_classes')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__weight_class_translations', function (Blueprint $table) {
      $table->dropForeign(['weight_class_id']);
    });
    Schema::dropIfExists('icommerce__weight_class_translations');
  }
}
