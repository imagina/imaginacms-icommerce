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
        Schema::table('icommerce__product_discounts', function (Blueprint $table) {
            $table->integer('department_id')->unsigned()->nullable();
            $table->foreign('department_id')->references('id')->on('iprofile__departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__product_discounts', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__product_discounts', 'department_id')) {
                $table->dropForeign('icommerce__product_discounts_department_id_foreign');
                $table->dropColumn('department_id');
            }
        });
    }
};
