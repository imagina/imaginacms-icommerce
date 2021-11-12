<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExternalIdInProductAndCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('icommerce__categories', function (Blueprint $table) {
        $table->string('external_id')->nullable();
      });
      Schema::table('icommerce__products', function (Blueprint $table) {
        $table->string('external_id')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('icommerce__categories', function (Blueprint $table) {
        $table->dropColumn('external_id');
      });
      Schema::table('icommerce__products', function (Blueprint $table) {
        $table->dropColumn('external_id');
      });
    }
}
