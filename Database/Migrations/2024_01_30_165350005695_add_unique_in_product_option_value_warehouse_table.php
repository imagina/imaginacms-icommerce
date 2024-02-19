<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniqueInProductOptionValueWarehouseTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    Schema::table('icommerce__product_option_value_warehouse', function (Blueprint $table) {
      //Unique to not repeat
      $table->unique(['warehouse_id','option_value_id'],'icommerce__product_option_value_warehouse_wov_id_unique');
    });
    
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
   
  }

}
