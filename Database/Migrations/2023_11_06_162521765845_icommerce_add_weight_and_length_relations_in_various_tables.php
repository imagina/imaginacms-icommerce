<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IcommerceAddWeightAndLengthRelationsInVariousTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('icommerce__products', function (Blueprint $table) {
        $table->integer("weight_class_id")->unsigned()->after("weight")->nullable();
        $table->foreign('weight_class_id')->references('id')->on('icommerce__weight_classes')->onDelete('restrict');
        $table->integer("length_class_id")->unsigned()->after("length")->nullable();
        $table->foreign('length_class_id')->references('id')->on('icommerce__length_classes')->onDelete('restrict');
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
