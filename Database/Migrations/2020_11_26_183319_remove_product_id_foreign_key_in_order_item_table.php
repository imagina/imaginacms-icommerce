<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('icommerce__order_item', function (Blueprint $table) {
            $table->dropForeign('icommerce__order_item_product_id_foreign');
            $table->dropForeign('icommerce__order_item_item_type_id_foreign');
            $table->dropForeign('icommerce__order_item_product_discount_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
