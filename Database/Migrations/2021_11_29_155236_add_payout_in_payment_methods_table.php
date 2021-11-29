<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayoutInPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__payment_methods', function (Blueprint $table) {
            $table->tinyInteger('payout')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__payment_methods', function (Blueprint $table) {
          if(Schema::hasColumn('icommerce__payment_methods','payout')) {
            $table->dropColumn('payout');
          }
        });
    }
}
