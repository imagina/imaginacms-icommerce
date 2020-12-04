<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOperationPrefixPriceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('icommerce__price_lists', function (Blueprint $table) {
        $table->enum('operation_prefix', ['+', '-'])->default('-');
        $table->float('value', 8, 2)->default(0);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('icommerce__price_lists', function (Blueprint $table) {
        $table->dropColumn(['operation_prefix','value']);
      });
    }
}
