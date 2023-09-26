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
            $table->tinyInteger('status')->default(1)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__categories', function (Blueprint $table) {
            if (Schema::hasColumn('icommerce__categories', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
