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
        Schema::create('icommerce__currency_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your translatable fields
            $table->text('name');

            $table->integer('currency_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['currency_id', 'locale']);
            $table->foreign('currency_id')->references('id')->on('icommerce__currencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('icommerce__currency_translations', function (Blueprint $table) {
            $table->dropForeign(['currency_id']);
        });
        Schema::dropIfExists('icommerce__currency_translations');
    }
};
