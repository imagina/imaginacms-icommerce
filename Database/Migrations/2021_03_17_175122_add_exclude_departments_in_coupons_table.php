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
            $table->text('exclude_departments')->nullable();
            $table->text('include_departments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__coupons', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__coupons', 'exclude_departments')) {
                $table->dropColumn('exclude_departments');
            }
            if (Schema::hasColumn('icommerce__coupons', 'include_departments')) {
                $table->dropColumn('include_departments');
            }
        });
    }
};
