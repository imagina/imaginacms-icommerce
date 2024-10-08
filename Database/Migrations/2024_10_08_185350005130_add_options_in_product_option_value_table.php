<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptionsInProductOptionValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('icommerce__product_option_value', function (Blueprint $table) {
        
        $table->text('options')->nullable()->after('stock_status');
       
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

        $table->dropColumn('options');
        
      });
    }
}
