<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommercePaymentMethodTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__payment_method_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');
            $table->text('description');
            
            $table->integer('payment_method_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['payment_method_id', 'locale'],'unique_payment_method_id');
            $table->foreign('payment_method_id')->references('id')->on('icommerce__payment_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__payment_method_translations', function (Blueprint $table) {
            $table->dropForeign(['payment_method_id']);
        });
        Schema::dropIfExists('icommerce__payment_method_translations');
    }
}
