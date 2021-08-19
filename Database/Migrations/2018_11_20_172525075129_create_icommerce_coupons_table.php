<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceCouponsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__coupons', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('code');
      $table->integer('type');
      $table->integer('category_id')->unsigned()->nullable();
      $table->foreign('category_id')->references('id')->on('icommerce__categories')->onDelete('restrict');
      $table->integer('product_id')->unsigned()->nullable();
      $table->foreign('product_id')->references('id')->on('icommerce__products')->onDelete('restrict');
      $table->integer('customer_id')->unsigned()->nullable();
      $table->foreign('customer_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
      $table->float('discount', 8, 2);
      $table->integer('type_discount');
      $table->boolean('logged')->default(false)->unsigned();
      $table->boolean('shipping')->default(false)->unsigned();
      $table->timestamp('date_start')->nullable();
      $table->timestamp('date_end')->nullable();
      $table->integer('quantity_total')->default(1)->unsigned();
      $table->integer('quantity_total_customer')->default(1)->unsigned();
      $table->integer('status')->default(0)->unsigned();
      $table->text('options')->nullable();

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
    Schema::dropIfExists('icommerce__coupons');
  }
}
