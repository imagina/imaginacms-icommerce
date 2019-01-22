<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('icommerce__order_option', function (Blueprint $table) {
        $table->dropForeign('icommerce__order_option_product_option_id_foreign');
        $table->dropForeign('icommerce__order_option_product_option_value_id_foreign');
        $table->dropColumn(['product_option_id','product_option_value_id']);
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
