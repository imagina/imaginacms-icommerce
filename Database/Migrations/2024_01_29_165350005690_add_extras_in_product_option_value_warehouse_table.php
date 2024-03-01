<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtrasInProductOptionValueWarehouseTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    Schema::table('icommerce__product_option_value_warehouse', function (Blueprint $table) {
      
      $table->integer('product_id')->unsigned()->after('quantity');
      $table->foreign('product_id')->references('id')->on('icommerce__products')->onDelete('cascade');

      $table->integer('option_id')->unsigned()->after('product_id');
      $table->foreign('option_id')->references('id')->on('icommerce__options')->onDelete('cascade');

      $table->integer('option_value_id')->unsigned()->after('option_id');
      $table->foreign('option_value_id','icommerce__product_option_value_warehouse_ov_id_foreign')->references('id')->on('icommerce__option_values')->onDelete('cascade');

    });
    
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {

    Schema::table('icommerce__product_option_value_warehouse', function (Blueprint $table) {
     
    });

  }

}
