<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceTaxClassRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__taxclassrates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('taxclass_id')->unsigned();
            $table->foreign('taxclass_id')->references('id')->on('icommerce__taxclasses');
            $table->integer('taxrate_id')->unsigned();
            $table->foreign('taxrate_id')->references('id')->on('icommerce__taxrates');
            $table->string('based');
            $table->integer('priority');
            // Your fields
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
        Schema::dropIfExists('icommerce__taxclassrates');
    }
}
