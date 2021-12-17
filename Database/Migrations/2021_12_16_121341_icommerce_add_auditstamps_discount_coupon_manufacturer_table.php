<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IcommerceAddAuditstampsDiscountCouponManufacturerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('icommerce__product_discounts', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('icommerce__coupons', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('icommerce__manufacturers', function (Blueprint $table) {
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
        //
    }
}
