<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceCouponCategoryTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__coupon_category', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields
      $table->integer('coupon_id')->unsigned();
      $table->foreign('coupon_id')->references('id')->on('icommerce__coupons')->onDelete('restrict');
      
      $table->integer('category_id')->unsigned();
      $table->foreign('category_id')->references('id')->on('icommerce__categories')->onDelete('restrict');
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
    Schema::dropIfExists('icommerce__coupon_category');
  }
}
