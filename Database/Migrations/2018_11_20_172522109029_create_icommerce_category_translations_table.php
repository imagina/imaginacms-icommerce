<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceCategoryTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__category_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      
      // Your translatable fields
      $table->text('title');
      $table->string('slug');
      $table->text('description')->nullable();
      $table->text('meta_title')->nullable();
      $table->text('meta_description')->nullable();
      
      $table->integer('category_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['category_id', 'locale']);
      $table->foreign('category_id')->references('id')->on('icommerce__categories')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__category_translations', function (Blueprint $table) {
      $table->dropForeign(['category_id']);
    });
    Schema::dropIfExists('icommerce__category_translations');
  }
}
