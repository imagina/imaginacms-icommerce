<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntityFieldsInProductAndOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__products', function (Blueprint $table) {
            $table->string('entity_type')->nullable()->after('freeshipping');
            $table->integer('entity_id')->unsigned()->nullable()->default(0)->after('freeshipping');
        });

        Schema::table('icommerce__order_item', function (Blueprint $table) {
            $table->string('entity_type')->nullable()->after('reward');
            $table->integer('entity_id')->unsigned()->nullable()->default(0)->after('reward');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__products', function (Blueprint $table) {
            $table->dropColumn('entity_id');
            $table->dropColumn('entity_type');
        });
        Schema::table('icommerce__order_item', function (Blueprint $table) {
            $table->dropColumn('entity_id');
            $table->dropColumn('entity_type');
        });
    }
}
