<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceMapareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__mapareas', function (Blueprint $table) {
            $table->increments('id');
            $table->text('polygon');
            $table->integer('store_id')->unsigned();
            $table->foreign('store_id')->references('id')->on('icommerce__stores')->onDelete('restrict');
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
        Schema::dropIfExists('icommerce__mapareas');
    }
}
