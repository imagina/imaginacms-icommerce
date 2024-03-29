<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParentInPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__payment_methods', function (Blueprint $table) {
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
        Schema::table('icommerce__payment_methods', function (Blueprint $table) {
          if(Schema::hasColumn('icommerce__payment_methods','parent_name')) {
            $table->dropColumn('parent_name');
          }
        });
    }
}
