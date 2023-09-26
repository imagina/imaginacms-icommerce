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
        Schema::table('icommerce__orders', function (Blueprint $table) {
            $table->string('payment_telephone')->nullable()->after('payment_last_name');
            $table->string('shipping_telephone')->nullable()->after('shipping_last_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__orders', function (Blueprint $table) {
            $table->dropColumn('payment_telephone');
            $table->dropColumn('shipping_telephone');
        });
    }
};
