<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
         *
         * 19-03-2021
         * JCEC
         * Esta migración se realizó para permitir que otros módulos puedan mandar a crear ordenes
         * con el mínimo necesario de campos: producto(s) y cliente, los demás campos se procesan
         * finalmente en el checkout
         *
         */

        Schema::table('icommerce__orders', function (Blueprint $table) {
            $table->string('telephone')->nullable()->default(null)->change();

            $table->string('payment_first_name')->nullable()->default(null)->change();
            $table->string('payment_last_name')->nullable()->default(null)->change();
            $table->text('payment_address_1')->nullable()->default(null)->change();
            $table->string('payment_city')->nullable()->default(null)->change();
            $table->string('payment_zip_code')->nullable()->default(null)->change();
            $table->string('payment_country')->nullable()->default(null)->change();
            $table->string('payment_method')->nullable()->default(null)->change();
            $table->string('payment_code')->nullable()->default(null)->change();

            $table->string('shipping_first_name')->nullable()->default(null)->change();
            $table->string('shipping_last_name')->nullable()->default(null)->change();
            $table->text('shipping_address_1')->nullable()->default(null)->change();
            $table->string('shipping_city')->nullable()->default(null)->change();
            $table->string('shipping_zip_code')->nullable()->default(null)->change();
            $table->string('shipping_country_code')->nullable()->default(null)->change();
            $table->string('shipping_method')->nullable()->default(null)->change();
            $table->string('shipping_code')->nullable()->default(null)->change();
            $table->decimal('shipping_amount', 15, 8)->nullable()->default(0)->change();

            $table->integer('store_id')->nullable()->default(null)->change();
            $table->string('store_name')->nullable()->default(null)->change();
            $table->text('store_address')->nullable()->default(null)->change();
            $table->string('store_phone')->nullable()->default(null)->change();

            $table->string('currency_code')->nullable()->default(null)->change();
            $table->decimal('currency_value', 15, 8)->nullable()->default(0)->change();

            $table->string('ip')->nullable()->default(null)->change();

            //default true para no dañar las vistas de ordenes viejas que no tomaban en cuenta esta nueva columna
            $table->boolean('require_shipping')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__orders', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__orders', 'require_shipping')) {
                $table->dropColumn('require_shipping');
            }
        });
    }
};
