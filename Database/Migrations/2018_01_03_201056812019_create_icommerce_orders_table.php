<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreateIcommerceOrdersTable extends Migration

{

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()

    {

        Schema::create('icommerce__orders', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->increments('id');

            // Your fields


            $table->integer('invoice_nro')->unsigned()->nullable();
            $table->string('invoice_prefix')->nullable();
            $table->float('total', 50, 2);
            $table->tinyInteger('order_status')->default(10)->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('telephone');
            $table->string('payment_firstname');
            $table->string('payment_lastname');
            $table->string('payment_company')->nullable();
            $table->text('payment_address_1');
            $table->text('payment_address_2')->nullable();
            $table->string('payment_city');
            $table->string('payment_postcode');
            $table->string('payment_country');
            $table->string('payment_zone')->nullable();
            $table->text('payment_address_format')->default('')->nullable();
            $table->text('payment_custom_field')->default('')->nullable();
            $table->string('payment_method');
            $table->string('payment_code');
            $table->string('shipping_firstname');
            $table->string('shipping_lastname');
            $table->string('shipping_company')->nullable();
            $table->text('shipping_address_1');
            $table->text('shipping_address_2')->nullable();
            $table->string('shipping_city');
            $table->string('shipping_postcode');
            $table->string('shipping_country');
            $table->string('shipping_zone')->nullable();
            $table->text('shipping_address_format')->default('')->nullable();
            $table->text('shipping_custom_field')->default('')->nullable();
            $table->string('shipping_method');
            $table->string('shipping_code');
            $table->double('shipping_amount', 15, 8)->default(0);
            $table->double('tax_amount', 15, 8)->nullable();
            $table->text('comment')->nullable();
            $table->text('tracking')->nullable();
            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('icommerce__currencies')->onDelete('restrict');
            $table->string('currency_code');
            $table->double('currency_value', 15, 8);
            $table->string('ip');
            $table->text('user_agent');
            $table->string('key')->nullable();;


            $table->timestamps();

        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()

    {

        Schema::dropIfExists('icommerce__orders');

    }

}

