<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IcommerceAddedFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__categories', function (Blueprint $table) {
            $table->integer('store_id')->unsigned()->nullable();
        });
        Schema::table('icommerce__category_translations', function (Blueprint $table) {
            $table->text('translatable_options')->nullable();
        });
        Schema::table('icommerce__manufacturers', function (Blueprint $table) {
            $table->integer('store_id')->unsigned()->nullable();
            $table->renameColumn('status', 'active');
        });
        Schema::table('icommerce__manufacturer_trans', function (Blueprint $table) {
            $table->string('slug')->nullable();
            $table->integer('translatable_options')->unsigned()->nullable();
        });
        Schema::table('icommerce__tax_rates', function (Blueprint $table) {
            $table->integer('store_id')->unsigned()->nullable();
        });
        Schema::table('icommerce__tax_classes', function (Blueprint $table) {
            $table->integer('store_id')->unsigned()->nullable();
        });
        Schema::table('icommerce__products', function (Blueprint $table) {
            $table->integer('store_id')->unsigned()->nullable();
        });
        Schema::table('icommerce__coupons', function (Blueprint $table) {
            $table->integer('store_id')->unsigned()->nullable();
        });
        Schema::table('icommerce__currencies', function (Blueprint $table) {
            $table->integer('store_id')->unsigned()->nullable();
        });
        Schema::table('icommerce__payment_methods', function (Blueprint $table) {
            $table->integer('store_id')->unsigned()->nullable();
        });
        Schema::table('icommerce__shipping_methods', function (Blueprint $table) {
            $table->integer('store_id')->unsigned()->nullable();
        });
    }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
  }
}
