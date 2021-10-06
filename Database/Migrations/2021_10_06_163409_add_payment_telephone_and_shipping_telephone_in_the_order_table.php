<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentTelephoneAndShippingTelephoneInTheOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__orders', function (Blueprint $table) {
          $table->string('payment_telephone')->nullable()->after('payment_last_name');
          $table->string('shipping_telephone')->nullable()->after('shipping_last_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__orders', function (Blueprint $table) {
          $table->dropColumn('external_id');
          $table->dropColumn('external_id');
        });
    }
}
