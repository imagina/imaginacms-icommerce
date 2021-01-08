<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductDiscountIdInOrderItemTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('icommerce__order_item', function (Blueprint $table) {
      
      $table->integer('product_discount_id')->unsigned()->nullable();
      $table->foreign('product_discount_id')->references('id')->on('icommerce__product_discounts')->onDelete('cascade');
      
      $table->text('discount')->nullable();
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__order_item', function (Blueprint $table) {
      $table->dropColumn('product_discount_id');
      $table->dropColumn('discount');
      $table->dropForeign('icommerce__order_item_product_discount_id_foreign');
    });
  }
}
