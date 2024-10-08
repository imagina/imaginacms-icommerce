<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentAttempsInOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('icommerce__orders', function (Blueprint $table) {
        
        $table->integer('payment_attemps')->unsigned()->default(0)->after('subscription_type');
        
       
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

        $table->dropColumn('payment_attemps');
        
      });
    }
}
