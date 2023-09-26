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
            $table->integer('item_type_id')->unsigned()->nullable();
            $table->foreign('item_type_id')->references('id')->on('icommerce__item_types')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__products', function (Blueprint $table) {
            $table->dropForeign(['item_type_id']);
            $table->dropColumn('item_type_id');
        });
    }
};
