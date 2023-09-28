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
        Schema::table('icommerce__payment_methods', function (Blueprint $table) {
            $table->string('parent_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__payment_methods', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__payment_methods', 'parent_name')) {
                $table->dropColumn('parent_name');
            }
        });
    }
};
