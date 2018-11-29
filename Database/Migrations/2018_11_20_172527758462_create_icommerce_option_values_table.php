<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceOptionValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__option_values', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
          $table->integer('option_id')->unsigned()->nullable();
          $table->foreign('option_id')->references('id')->on('icommerce__options')->onDelete('restrict');
  
          $table->text('image')->default('')->nullable();
          $table->integer('sort_order')->default(0);
          $table->text('options')->default('')->nullable();
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
        Schema::dropIfExists('icommerce__option_values');
    }
}
