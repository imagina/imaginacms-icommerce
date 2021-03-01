<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParentInShippingMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__shipping_methods', function (Blueprint $table) {
            $table->string('parent_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__shipping_methods', function (Blueprint $table) {
			$table->dropColumn('parent_name');
        });
    }
}
