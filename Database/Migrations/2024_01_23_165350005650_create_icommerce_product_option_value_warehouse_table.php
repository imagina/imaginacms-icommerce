<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceProductOptionValueWarehouseTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__product_option_value_warehouse', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields
      $table->integer('product_option_value_id')->unsigned();
      $table->foreign('product_option_value_id','icommerce__product_option_value_warehouse_pov_id_foreign')->references('id')->on('icommerce__product_option_value')->onDelete('cascade');

      $table->integer('warehouse_id')->unsigned();
      $table->foreign('warehouse_id')->references('id')->on('icommerce__warehouses')->onDelete('cascade');

      $table->integer('quantity')->default(0)->unsigned();

      $table->timestamps();
      $table->auditStamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('icommerce__product_option_value_warehouse');
  }
}
