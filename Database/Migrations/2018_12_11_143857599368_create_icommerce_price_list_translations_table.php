<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommercePriceListTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__price_list_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('name');
          
            $table->integer('price_list_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['price_list_id', 'locale']);
            $table->foreign('price_list_id')->references('id')->on('icommerce__price_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__price_list_translations', function (Blueprint $table) {
            $table->dropForeign(['price_list_id']);
        });
        Schema::dropIfExists('icommerce__price_list_translations');
    }
}
