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
        Schema::table('icommerce__order_status_history', function (Blueprint $table) {

          $table->longText('options')->nullable()->after('comment');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

      Schema::table('icommerce__order_status_history', function (Blueprint $table) {
        $table->dropColumn('options');
      });

    }

};
