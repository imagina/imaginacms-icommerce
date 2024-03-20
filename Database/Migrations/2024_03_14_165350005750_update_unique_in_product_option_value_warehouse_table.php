<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUniqueInProductOptionValueWarehouseTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    Schema::disableForeignKeyConstraints();

    Schema::table('icommerce__product_option_value_warehouse', function (Blueprint $table) {
      //Delete Unique
      $table->dropUnique('icommerce__product_option_value_warehouse_wov_id_unique');
      //Unique to not repeat
      $table->unique(['warehouse_id','product_option_value_id'],'icommerce__product_option_value_id_warehouse_wov_id_unique');
    });

    Schema::enableForeignKeyConstraints();
    
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
