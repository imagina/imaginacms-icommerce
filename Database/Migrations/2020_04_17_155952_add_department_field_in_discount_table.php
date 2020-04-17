<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentFieldInDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__product_discounts', function (Blueprint $table) {
          $table->integer('department_id')->unsigned()->nullable();
          $table->foreign('department_id')->references('id')->on('iprofile__departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__product_discounts', function (Blueprint $table) {
          $table->dropForeign('icommerce__product_discounts_department_id_foreign');
          $table->dropColumn('department_id');
        });
    }
}
