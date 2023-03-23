<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IcommerceAddLocaleColumnInCurrencyTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('icommerce__currencies', function (Blueprint $table) {
      $table->string('locale')->nullable()->after('default_currency');
      $table->string('decimal_separator')->default(".")->after('default_currency');
      $table->string('thousands_separator')->default(",")->after('default_currency');
      $table->renameColumn('decimal_place', 'decimals');
    });
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('icommerce__currencies', function (Blueprint $table) {
      $table->dropColumn('locale');
      $table->dropColumn('decimal_separator');
      $table->dropColumn('thousands_separator');
    });
    
  }
}
