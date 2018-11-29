<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceOrderStatusTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__order_status_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your translatable fields
      $table->string('title');
      $table->integer('order_status_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['order_status_id', 'locale']);
      $table->foreign('order_status_id')->references('id')->on('icommerce__order_statuses')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__order_status_translations', function (Blueprint $table) {
      $table->dropForeign(['order_status_id']);
    });
    Schema::dropIfExists('icommerce__order_status_translations');
  }
}
