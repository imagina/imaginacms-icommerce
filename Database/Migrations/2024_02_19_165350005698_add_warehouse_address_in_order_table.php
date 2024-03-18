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
    
      $table->text('warehouse_address')->after('warehouse_title')->nullable();
  
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
      $table->dropColumn('warehouse_address');
    });
  }

};
