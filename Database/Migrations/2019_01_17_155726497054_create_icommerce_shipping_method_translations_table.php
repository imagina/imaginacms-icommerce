<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceShippingMethodTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__shipping_method_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');
            $table->text('description');

            $table->integer('shipping_method_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['shipping_method_id', 'locale'],'unique_shipping_method_id');
            $table->foreign('shipping_method_id','sm_id_foreing')->references('id')->on('icommerce__shipping_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__shipping_method_translations', function (Blueprint $table) {
            $table->dropForeign(['shippingmethod_id']);
        });
        Schema::dropIfExists('icommerce__shipping_method_translations');
    }
}
