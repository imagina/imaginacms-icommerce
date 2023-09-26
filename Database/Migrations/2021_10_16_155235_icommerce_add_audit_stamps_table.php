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
        Schema::table('icommerce__products', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('icommerce__categories', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('icommerce__carts', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('icommerce__orders', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('icommerce__order_item', function (Blueprint $table) {
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
