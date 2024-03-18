<?php

use Illuminate\Support\Facades\Schema;
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
     
      Schema::table('icommerce__cart_product_options', function (Blueprint $table) {
      
        $table->integer('option_id')->unsigned()->nullable()->after('product_option_value_id');
        $table->foreign('option_id')->references('id')->on('icommerce__options')->onDelete('cascade');

        $table->text('value')->nullable()->after('option_id');

      });
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

      Schema::table('icommerce__cart_product_options', function (Blueprint $table) {
        
        $table->dropColumn('option_id');
        $table->dropForeign(['option_id']);

        $table->dropColumn('value');

      });

    }
};
