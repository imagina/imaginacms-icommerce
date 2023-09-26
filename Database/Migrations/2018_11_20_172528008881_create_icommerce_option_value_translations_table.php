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
        Schema::create('icommerce__option_value_trans', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your translatable fields
            $table->text('description');

            $table->integer('option_value_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['option_value_id', 'locale']);
            $table->foreign('option_value_id')->references('id')->on('icommerce__option_values')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('icommerce__option_value_trans', function (Blueprint $table) {
            $table->dropForeign(['option_value_id']);
        });
        Schema::dropIfExists('icommerce__option_value_trans');
    }
};
