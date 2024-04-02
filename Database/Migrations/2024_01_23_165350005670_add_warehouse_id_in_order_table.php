<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('icommerce__orders', function (Blueprint $table) {
    
      $table->integer('warehouse_id')->unsigned()->after('key')->nullable();
      $table->text('warehouse_title')->after('warehouse_id')->nullable();
  
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
      $table->dropColumn('warehouse_id');
      $table->dropColumn('warehouse_title');
    });
  }

};
