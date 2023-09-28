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
        Schema::table('icommerce__coupons', function (Blueprint $table) {
            $table->float('minimum_order_amount', 50, 2)->default(0);
            $table->integer('minimum_quantity_products')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__coupons', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__coupons', 'minimum_order_amount')) {
                $table->dropColumn('minimum_order_amount');
            }
            if (Schema::hasColumn('icommerce__coupons', 'minimum_quantity_products')) {
                $table->dropColumn('minimum_quantity_products');
            }
        });
    }
};
