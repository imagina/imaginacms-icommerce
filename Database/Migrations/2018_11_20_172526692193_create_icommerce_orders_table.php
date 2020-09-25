<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
          
          $table->integer('status_id')->unsigned();
          $table->foreign('status_id')->references('id')->on('icommerce__order_statuses')->onDelete('restrict');
  
          $table->integer('customer_id')->unsigned()->nullable();
          $table->foreign('customer_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
  
          $table->integer('added_by_id')->unsigned()->nullable();
          $table->foreign('added_by_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
          
          $table->string('first_name');
          $table->string('last_name');
          $table->string('email');
          $table->string('telephone');
          
          $table->string('payment_first_name');
          $table->string('payment_last_name');
          $table->string('payment_company')->nullable();
          $table->string('payment_nit')->nullable();
          $table->text('payment_address_1');
          $table->text('payment_address_2')->nullable();
          $table->string('payment_city');
          $table->string('payment_zip_code');
          $table->string('payment_country');
          $table->string('payment_zone')->nullable();
          $table->text('payment_address_format')->nullable();
          $table->text('payment_custom_field')->nullable();
    
          $table->string('payment_method');
          $table->string('payment_code');

          $table->string('shipping_first_name');
          $table->string('shipping_last_name');
          $table->string('shipping_company')->nullable();
          $table->text('shipping_address_1');
          $table->text('shipping_address_2')->nullable();
          $table->string('shipping_city');
          $table->string('shipping_zip_code');
          $table->string('shipping_country_code');
          $table->string('shipping_zone')->nullable();
          $table->text('shipping_address_format')->nullable();
          $table->text('shipping_custom_field')->nullable();
          $table->string('shipping_method');
          $table->string('shipping_code');
          $table->double('shipping_amount', 15, 8)->default(0);
          
          $table->integer('store_id');
          $table->string('store_name');
          $table->text('store_address');
          $table->string('store_phone');
          
          $table->double('tax_amount', 15, 8)->nullable();
          
          $table->text('comment')->nullable();
          
          $table->text('tracking')->nullable();
          
          $table->integer('currency_id')->unsigned()->nullable();
          $table->foreign('currency_id')->references('id')->on('icommerce__currencies')->onDelete('restrict');
          $table->string('currency_code');
          $table->double('currency_value', 15, 8);
          
          $table->string('ip');
          $table->text('user_agent')->nullable();
          $table->string('key')->nullable();
  
          $table->longText('options')->nullable();
          
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
