<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStockStatusOnProductOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__product_option_value', function (Blueprint $table) {
            $table->tinyInteger('stock_status')->default(1)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__product_option_value', function (Blueprint $table) {
            $table->dropColumn('stock_status');
        });
    }
}
