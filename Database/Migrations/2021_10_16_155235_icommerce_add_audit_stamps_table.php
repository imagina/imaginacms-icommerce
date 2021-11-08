<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IcommerceAddAuditStampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__products', function (Blueprint $table) {
          $table->auditStamps();
        });
      Schema::table('icommerce__categories', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('icommerce__carts', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('icommerce__orders', function (Blueprint $table) {
        $table->auditStamps();
      });
      Schema::table('icommerce__order_item', function (Blueprint $table) {
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
    
    }
}
