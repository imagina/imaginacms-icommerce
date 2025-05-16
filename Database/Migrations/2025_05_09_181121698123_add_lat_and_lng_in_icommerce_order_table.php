<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatAndLngInIcommerceOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__orders', function (Blueprint $table) {

          $table->string('shipping_address_lat')->nullable()->after('shipping_zone');
          $table->string('shipping_address_lng')->nullable()->after('shipping_address_lat');

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
        $table->dropColumn('shipping_address_lat');
        $table->dropColumn('shipping_address_lng');
      });

    }

};
