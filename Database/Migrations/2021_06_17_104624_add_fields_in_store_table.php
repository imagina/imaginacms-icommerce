<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsInStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__stores', function (Blueprint $table) {
          
          $table->integer('user_id')->unsigned()->nullable();
          $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__stores', function (Blueprint $table) {
          $table->dropColumn('user_id');
          $table->dropForeign('user_id');
        });
    }
}
