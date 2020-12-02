<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceTaxRateTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__tax_rate_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      
      // Your translatable fields
      $table->string('name');
      
      $table->integer('tax_rate_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['tax_rate_id', 'locale']);
      $table->foreign('tax_rate_id')->references('id')->on('icommerce__tax_rates')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__tax_rate_translations', function (Blueprint $table) {
      $table->dropForeign(['tax_rate_id']);
    });
    Schema::dropIfExists('icommerce__tax_rate_translations');
  }
}
