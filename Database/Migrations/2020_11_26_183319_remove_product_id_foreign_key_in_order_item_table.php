<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveProductIdForeignKeyInOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__order_item', function (Blueprint $table) {
          $table->dropForeign('icommerce__order_item_product_id_foreign');
          $table->dropForeign('icommerce__order_item_item_type_id_foreign');
          $table->dropForeign('icommerce__order_item_product_discount_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    
    }
}
