<?php

use Illuminate\Support\Facades\Schema;
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
      Schema::table('icommerce__order_statuses', function (Blueprint $table) {
        $table->auditStamps();
      });

      Schema::table('icommerce__payment_methods_geozones', function (Blueprint $table) {
        $table->auditStamps();
      });

      Schema::table('icommerce__tax_rates', function (Blueprint $table) {
        $table->auditStamps();
      });

      Schema::table('icommerce__transactions', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('icommerce__tax_class_rate', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('icommerce__order_options', function (Blueprint $table) {
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
};
