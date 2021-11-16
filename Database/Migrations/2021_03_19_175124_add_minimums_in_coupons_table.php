<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMinimumsInCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__coupons', function (Blueprint $table) {
          $table->float('minimum_order_amount',50, 2)->default(0);
          $table->integer('minimum_quantity_products')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__coupons', function (Blueprint $table) {
          if(Schema::hasColumn('icommerce__coupons','minimum_order_amount')) {
            $table->dropColumn('minimum_order_amount');
          }
          if(Schema::hasColumn('icommerce__coupons','minimum_quantity_products')) {
            $table->dropColumn('minimum_quantity_products');
          }
        });
    }
}
