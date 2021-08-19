<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceProductableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__productable', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('productable_type');
            $table->integer('productable_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->index(['productable_type', 'productable_id'], 'productable_type_id_foreign');

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
        Schema::dropIfExists('icommerce__productable');
    }
}
