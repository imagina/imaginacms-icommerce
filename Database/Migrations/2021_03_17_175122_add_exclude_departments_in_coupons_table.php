<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExcludeDepartmentsInCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__coupons', function (Blueprint $table) {
          $table->text('exclude_departments')->nullable();
          $table->text('include_departments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__coupons', function (Blueprint $table) {
          $table->dropColumn('exclude_departments');
          $table->dropColumn('include_departments');
        });
    }
}
