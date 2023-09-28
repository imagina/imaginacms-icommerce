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
        Schema::create('icommerce__currencies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->string('code');
            $table->string('symbol_left')->nullable();
            $table->string('symbol_right')->nullable();
            $table->char('decimal_place', 1)->nullable();
            $table->double('value', 15, 8);
            $table->tinyInteger('status')->default(0)->unsigned();
            $table->boolean('default_currency')->default(false);
            $table->text('options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('icommerce__currencies');
    }
};
