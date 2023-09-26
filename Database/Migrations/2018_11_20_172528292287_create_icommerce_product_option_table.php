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
        Schema::create('icommerce__product_option', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('icommerce__products')->onDelete('cascade');

            $table->integer('option_id')->unsigned();
            $table->foreign('option_id')->references('id')->on('icommerce__options')->onDelete('cascade');

            $table->integer('parent_id')->unsigned()->default(0);
            $table->integer('lft')->unsigned()->nullable();
            $table->integer('rgt')->unsigned()->nullable();
            $table->integer('depth')->unsigned()->nullable();

            $table->integer('parent_option_value_id')->unsigned()->nullable();
            $table->foreign('parent_option_value_id')
              ->references('id')
              ->on('icommerce__option_values')
              ->onDelete('restrict');

            $table->string('value')->nullable();
            $table->integer('required')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('icommerce__product_option');
    }
};
