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
       
        Schema::table('icommerce__order_options', function (Blueprint $table) {
    
            $table->integer('option_value_id')->unsigned()->nullable()->after('order_item_id');
            $table->foreign('option_value_id')->references('id')->on('icommerce__option_values')->onDelete('restrict');

            $table->integer('option_id')->unsigned()->nullable()->after('option_value_description');
            $table->foreign('option_id')->references('id')->on('icommerce__options')->onDelete('restrict');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
        Schema::table('icommerce__order_options', function (Blueprint $table) {

            $table->dropColumn('option_value_id');
            $table->dropColumn('option_id');
            
        });
    }

};