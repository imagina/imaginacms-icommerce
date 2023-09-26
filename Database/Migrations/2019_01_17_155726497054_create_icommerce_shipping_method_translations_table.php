<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('icommerce__shipping_method_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->string('title');
            $table->text('description');

            $table->integer('shipping_method_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['shipping_method_id', 'locale'], 'unique_shipping_method_id');
            $table->foreign('shipping_method_id', 'sm_id_foreing')->references('id')->on('icommerce__shipping_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__shipping_method_translations', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__shipping_method_translations', 'shippingmethod_id')) {
                $table->dropForeign(['shippingmethod_id']);
            }
        });
        Schema::dropIfExists('icommerce__shipping_method_translations');
    }
};
