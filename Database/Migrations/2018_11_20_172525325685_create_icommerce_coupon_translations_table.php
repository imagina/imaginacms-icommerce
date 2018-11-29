<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceCouponTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__coupon_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->strong('name');
            $table->integer('coupon_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['coupon_id', 'locale']);
            $table->foreign('coupon_id')->references('id')->on('icommerce__coupons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__coupon_translations', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']);
        });
        Schema::dropIfExists('icommerce__coupon_translations');
    }
}
