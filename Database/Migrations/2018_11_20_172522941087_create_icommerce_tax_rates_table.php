<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceTaxRatesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__tax_rates', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields

      $table->decimal('rate',50,2);
      $table->string('type', 2);
      $table->integer('geozone_id')->unsigned();
      $table->foreign('geozone_id')->references('id')->on('ilocations__geozones');
      $table->boolean('customer')->default(0);
      $table->integer('tax_class_id')->unsigned();
      $table->foreign('tax_class_id')->references('id')->on('icommerce__tax_classes');
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
    Schema::dropIfExists('icommerce__tax_rates');
  }
}
