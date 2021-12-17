<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IcommerceAddAuditstampsOptionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('icommerce__options', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('icommerce__option_values', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('icommerce__product_option', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('icommerce__product_option_value', function (Blueprint $table) {
        $table->auditStamps();
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
