<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__warehouses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...
            $table->string('lat');
            $table->string('lng');
            $table->text('address');
            $table->boolean('status')->default(false);
            $table->text('options')->nullable();

            //From ilocations
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('ilocations__countries')->onDelete('restrict');
            $table->integer('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('ilocations__provinces')->onDelete('restrict');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('ilocations__cities')->onDelete('restrict');
            $table->integer('polygon_id')->unsigned()->nullable();
            $table->foreign('polygon_id')->references('id')->on('ilocations__polygons')->onDelete('restrict');

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
        Schema::dropIfExists('icommerce__warehouses');
    }
}
