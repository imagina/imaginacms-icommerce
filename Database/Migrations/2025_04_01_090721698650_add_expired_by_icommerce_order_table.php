<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExpiredByIcommerceOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__orders', function (Blueprint $table) {

          $table->integer('expired_by_id')->unsigned()->nullable()->after('added_by_id');
          $table->foreign('expired_by_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

      Schema::table('icommerce__orders', function (Blueprint $table) {
        $table->dropForeign(['expired_by_id']);
        $table->dropColumn('expired_by_id');
      });

    }

}
