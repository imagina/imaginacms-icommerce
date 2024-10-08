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
      Schema::table('icommerce__subscriptions', function (Blueprint $table) {
        
        $table->integer('days_before_due')->unsigned()->default(0)->after('due_date');
        $table->integer('days_for_suspension')->unsigned()->default(0)->after('days_before_due');
       
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('icommerce__subscriptions', function (Blueprint $table) {

        $table->dropColumn('days_before_due');
        $table->dropColumn('days_for_suspension');
        
      });
    }

};
