<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSortOrderColumnInCategoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('icommerce__categories', function (Blueprint $table) {
      $table->integer('sort_order')->default(0);
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__categories', function (Blueprint $table) {
      $table->dropColumn('sort_order');
    });
  }
}
