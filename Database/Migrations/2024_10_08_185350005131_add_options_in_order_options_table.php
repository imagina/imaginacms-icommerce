<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptionsInOrderOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('icommerce__order_options', function (Blueprint $table) {
        
        $table->text('options')->nullable()->after('required');
       
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

        $table->dropColumn('options');
        
      });
    }
}
