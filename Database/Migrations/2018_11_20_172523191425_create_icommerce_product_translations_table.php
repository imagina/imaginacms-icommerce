<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceProductTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__product_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      
      // Your translatable fields
      $table->text('name');
      $table->string('slug');
      $table->text('description');
      $table->text('summary');
      
      $table->integer('product_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['product_id', 'locale']);
      $table->foreign('product_id')->references('id')->on('icommerce__products')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__product_translations', function (Blueprint $table) {
      $table->dropForeign(['product_id']);
    });
    Schema::dropIfExists('icommerce__product_translations');
  }
}
