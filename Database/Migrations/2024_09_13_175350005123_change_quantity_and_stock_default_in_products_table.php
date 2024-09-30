<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class changeQuantityAndStockDefaultInProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      \DB::statement("ALTER TABLE icommerce__products ALTER COLUMN stock_status SET DEFAULT 1");
      
      Schema::table('icommerce__products', function (Blueprint $table) {
        $table->integer('quantity')->default(1)->unsigned()->change();
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
