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
        Schema::table('icommerce__manufacturers', function (Blueprint $table) {
            $table->integer('sort_order')->default(0);
            $table->renameColumn('active', 'status');
        });

        Schema::table('icommerce__manufacturer_trans', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__manufacturers', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__manufacturers', 'sort_order')) {
                $table->dropColumn('sort_order');
            }
        });
        Schema::table('icommerce__manufacturer_trans', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__manufacturer_trans', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('icommerce__manufacturer_trans', 'meta_title')) {
                $table->dropColumn('meta_title');
            }
            if (Schema::hasColumn('icommerce__manufacturer_trans', 'meta_description')) {
                $table->dropColumn('meta_description');
            }
        });
    }
};
