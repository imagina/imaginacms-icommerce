<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('icommerce__order_item', function (Blueprint $table) {
            $table->integer('product_discount_id')->unsigned()->nullable();
            $table->foreign('product_discount_id')->references('id')->on('icommerce__product_discounts')->onDelete('cascade');

            $table->text('discount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('icommerce__order_item', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__order_item', 'product_discount_id')) {
                //$table->dropForeign(['product_discount_id']);
                $table->dropColumn('product_discount_id');
            }
            if (Schema::hasColumn('icommerce__order_item', 'discount')) {
                $table->dropColumn('discount');
            }
        });
    }
};
