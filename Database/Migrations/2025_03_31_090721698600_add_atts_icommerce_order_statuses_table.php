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
        Schema::table('icommerce__order_statuses', function (Blueprint $table) {

          $table->integer('type')->default(0)->unsigned()->after('status');
          $table->boolean("final")->default(false)->after('type');
          $table->boolean("default")->default(false)->after('final');
          $table->string("color")->nullable()->after('default');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

      Schema::table('icommerce__order_statuses', function (Blueprint $table) {
        $table->dropColumn(['type', 'final', 'default', 'color']);
      });

    }
};
