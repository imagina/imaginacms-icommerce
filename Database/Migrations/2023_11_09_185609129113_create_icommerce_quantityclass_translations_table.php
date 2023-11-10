<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceQuantityClassTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__quantity_class_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your translatable fields
      $table->string('title');
      $table->string('unit');
      
      $table->integer('quantity_class_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['quantity_class_id', 'locale'],"quantity_class_locale_unique_trans");
      $table->foreign('quantity_class_id')->references('id')->on('icommerce__quantity_classes')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__quantity_class_translations', function (Blueprint $table) {
      $table->dropForeign(['quantity_class_id']);
    });
    Schema::dropIfExists('icommerce__quantity_class_translations');
  }
}
