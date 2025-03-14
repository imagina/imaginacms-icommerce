<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDetailsInCartProductAndOrderItemTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('icommerce__cart_product', function (Blueprint $table) {
      $table->longText('details')->after('options')->nullable();
    });
    Schema::table('icommerce__order_item', function (Blueprint $table) {
      $table->longText('details')->after('options')->nullable();
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
