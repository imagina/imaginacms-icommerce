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
        Schema::table('icommerce__product_option_value', function (Blueprint $table) {
            $table->integer('parent_prod_opt_val_id')->after('weight_prefix')->unsigned()->nullable();
            //ppov => parent_product_option_value
            $table->foreign('parent_prod_opt_val_id')->references('id')->on('icommerce__product_option_value')->onDelete('restrict');
            \DB::statement("ALTER TABLE `icommerce__product_option_value` CHANGE  `stock_status` `stock_status`  TINYINT(3) UNSIGNED NOT NULL DEFAULT '1' AFTER `weight_prefix`");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
