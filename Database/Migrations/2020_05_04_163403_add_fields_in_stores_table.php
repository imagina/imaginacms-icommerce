<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsInStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__stores', function (Blueprint $table) {

          $table->integer('country_id')->unsigned()->nullable();
          $table->foreign('country_id')->references('id')->on('ilocations__countries')->onDelete('cascade');

          $table->integer('province_id')->unsigned()->nullable();
          $table->foreign('province_id')->references('id')->on('ilocations__provinces')->onDelete('cascade');

          $table->integer('city_id')->unsigned()->nullable();
          $table->foreign('city_id')->references('id')->on('ilocations__cities')->onDelete('cascade');

          $table->text('polygon')->nullable();

          $table->text('options')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__stores', function (Blueprint $table) {
          if(Schema::hasColumn('icommerce__stores','country_id')) {
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');
          }
          if(Schema::hasColumn('icommerce__stores','province_id')) {
            $table->dropForeign(['province_id']);
            $table->dropColumn('province_id');
          }
          if(Schema::hasColumn('icommerce__stores','city_id')) {
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
          }
          if(Schema::hasColumn('icommerce__stores','options')) {
            $table->dropColumn('options');
          }
          if(Schema::hasColumn('icommerce__stores','polygon')) {
            $table->dropColumn('polygon');
          }
        });
    }
}
