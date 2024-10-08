<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__subscriptions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields...
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('icommerce__orders')->onDelete('restrict');

            $table->integer('order_item_id')->unsigned();
            $table->foreign('order_item_id')->references('id')->on('icommerce__order_item')->onDelete('restrict');

            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('icommerce__products')->onDelete('restrict');

            $table->integer('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');

            $table->integer('order_option_id')->unsigned();
            $table->foreign('order_option_id')->references('id')->on('icommerce__order_options')->onDelete('restrict');
            $table->string('option_description');
            $table->string('option_value_description');

            $table->string('payment_method');
            $table->string('payment_code');
            $table->integer('currency_id')->unsigned()->nullable();
            $table->foreign('currency_id')->references('id')->on('icommerce__currencies')->onDelete('restrict');
            $table->string('currency_code');
            $table->double('currency_value', 15, 8);

            $table->double('price', 30, 2)->default(0);

            $table->integer('frequency')->unsigned();
            $table->dateTime('due_date');

            $table->integer('status_id')->default(0)->unsigned();

            $table->longText('options')->nullable();

            // Audit fields
            $table->timestamps();
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('icommerce__subscriptions');
    }

};