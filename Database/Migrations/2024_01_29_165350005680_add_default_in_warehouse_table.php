<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultInWarehouseTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('icommerce__warehouses', function (Blueprint $table) {
      $table->boolean('default')->default(false)->after('options');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__warehouses', function (Blueprint $table) {
      $table->dropColumn('default');
    });
  }

}
