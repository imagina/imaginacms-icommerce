<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__volume_class_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your translatable fields
      $table->string('title');
      $table->string('unit');
      
      $table->integer('volume_class_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['volume_class_id', 'locale'],"volume_class_locale_unique_trans");
      $table->foreign('volume_class_id')->references('id')->on('icommerce__volume_classes')->onDelete('cascade');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__volume_class_translations', function (Blueprint $table) {
      $table->dropForeign(['volume_class_id']);
    });
    Schema::dropIfExists('icommerce__volume_class_translations');
  }
};
