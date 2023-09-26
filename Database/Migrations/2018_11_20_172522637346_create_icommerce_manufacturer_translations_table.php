<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // OJO : toco esta tabla reducirle el nombre a trans porque excedia
        // el max de caracteres de mysql al momento de generar la llave unique
        Schema::create('icommerce__manufacturer_trans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your translatable fields
            $table->string('name');

            $table->integer('manufacturer_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['manufacturer_id', 'locale']);
            $table->foreign('manufacturer_id')->references('id')->on('icommerce__manufacturers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('icommerce__manufacturer_trans', function (Blueprint $table) {
            $table->dropForeign(['manufacturer_id']);
        });
        Schema::dropIfExists('icommerce__manufacturer_trans');
    }
};
