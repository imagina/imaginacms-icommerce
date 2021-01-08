<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceTaxClassRateTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__tax_class_rate', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields
      $table->integer('tax_class_id')->unsigned();
      $table->foreign('tax_class_id')->references('id')->on('icommerce__tax_classes');
      $table->integer('tax_rate_id')->unsigned();
      $table->foreign('tax_rate_id')->references('id')->on('icommerce__tax_rates');
      $table->string('based');
      $table->integer('priority');
      
      $table->timestamps();
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('icommerce__tax_class_rate');
  }
}
