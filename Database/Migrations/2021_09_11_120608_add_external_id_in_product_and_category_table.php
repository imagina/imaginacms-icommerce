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
        Schema::table('icommerce__categories', function (Blueprint $table) {
            $table->string('external_id')->nullable();
        });
        Schema::table('icommerce__products', function (Blueprint $table) {
            $table->string('external_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__categories', function (Blueprint $table) {
            $table->dropColumn('external_id');
        });
        Schema::table('icommerce__products', function (Blueprint $table) {
            $table->dropColumn('external_id');
        });
    }
};
