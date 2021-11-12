<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGeozoneIdInPaymentMethods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__payment_methods', function (Blueprint $table) {
          $table->integer('geozone_id')->unsigned()->nullable();
          $table->foreign('geozone_id')->references('id')->on('ilocations__geozones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__payment_methods', function (Blueprint $table) {
          if(Schema::hasColumn('icommerce__payment_methods','geozone_id')) {
            $table->dropForeign('icommerce__payment_methods_geozone_id_foreign');
            $table->dropColumn('geozone_id');
          }
        });
    }
}
