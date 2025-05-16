<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('icommerce__cart_product', function (Blueprint $table) {
      $table->string('details', 300)->after('options')->nullable();
    });
    Schema::table('icommerce__order_item', function (Blueprint $table) {
      $table->string('details', 300)->after('options')->nullable();
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
};
