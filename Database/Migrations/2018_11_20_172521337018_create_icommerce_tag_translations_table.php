<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceTagTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__tag_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your translatable fields
      $table->text('title');
      $table->string('slug');
      $table->integer('tag_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['tag_id', 'locale']);
      $table->foreign('tag_id')->references('id')->on('icommerce__tags')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__tag_translations', function (Blueprint $table) {
      $table->dropForeign(['tag_id']);
    });
    Schema::dropIfExists('icommerce__tag_translations');
  }
}
