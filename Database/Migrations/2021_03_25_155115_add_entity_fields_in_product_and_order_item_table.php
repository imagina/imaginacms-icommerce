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
            $table->string('entity_type')->nullable()->after('freeshipping');
            $table->integer('entity_id')->unsigned()->nullable()->default(0)->after('freeshipping');
        });

        Schema::table('icommerce__order_item', function (Blueprint $table) {
            $table->string('entity_type')->nullable()->after('reward');
            $table->integer('entity_id')->unsigned()->nullable()->default(0)->after('reward');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__products', function (Blueprint $table) {
            $table->dropColumn('entity_id');
            $table->dropColumn('entity_type');
        });
        Schema::table('icommerce__order_item', function (Blueprint $table) {
            $table->dropColumn('entity_id');
            $table->dropColumn('entity_type');
        });
    }
};
