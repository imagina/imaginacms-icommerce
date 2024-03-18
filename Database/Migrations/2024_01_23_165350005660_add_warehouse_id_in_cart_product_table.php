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
    Schema::table('icommerce__cart_product', function (Blueprint $table) {
    
      $table->integer('warehouse_id')->unsigned()->after('product_id')->nullable();
      $table->foreign('warehouse_id')->references('id')->on('icommerce__warehouses')->onDelete('cascade');
     
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__cart_product', function (Blueprint $table) {
      $table->dropColumn('warehouse_id');
    });
  }

};
