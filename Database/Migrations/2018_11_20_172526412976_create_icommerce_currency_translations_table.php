<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceCurrencyTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__currency_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      
      // Your translatable fields
      $table->text('name');
      
      $table->integer('currency_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['currency_id', 'locale']);
      $table->foreign('currency_id')->references('id')->on('icommerce__currencies')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__currency_translations', function (Blueprint $table) {
      $table->dropForeign(['currency_id']);
    });
    Schema::dropIfExists('icommerce__currency_translations');
  }
}
