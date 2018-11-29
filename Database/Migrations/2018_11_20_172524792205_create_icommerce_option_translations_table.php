<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceOptionTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__option_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your translatable fields
      $table->text('description');
      $table->integer('option_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['option_id', 'locale']);
      $table->foreign('option_id')->references('id')->on('icommerce__options')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__option_translations', function (Blueprint $table) {
      $table->dropForeign(['option_id']);
    });
    Schema::dropIfExists('icommerce__option_translations');
  }
}
