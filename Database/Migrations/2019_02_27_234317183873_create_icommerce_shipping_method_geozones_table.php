<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('icommerce__shipping_methods_geozones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields

            $table->integer('shipping_method_id')->unsigned();
            $table->foreign('shipping_method_id')->references('id')->on('icommerce__shipping_methods')->onDelete('restrict');

            $table->integer('geozone_id')->unsigned();
            $table->foreign('geozone_id')->references('id')->on('ilocations__geozones')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('icommerce__shipping_methods_geozones');
    }
};
