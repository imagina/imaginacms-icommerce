<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceAddressWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__address_warehouse', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...
            $table->integer('address_id')->unsigned();
            $table->foreign('address_id')->references('id')->on('iprofile__addresses')->onDelete('cascade');
            $table->integer('warehouse_id')->unsigned();
            $table->foreign('warehouse_id')->references('id')->on('icommerce__warehouses')->onDelete('cascade');

            //Unique to not repeat
            $table->unique(['address_id','warehouse_id']);

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
        Schema::dropIfExists('icommerce__warehouse_address');
    }
}
