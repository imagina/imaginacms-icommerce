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
            $table->string('suscription_id')->nullable();
            $table->text('suscription_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__orders', function (Blueprint $table) {
            $table->dropColumn('suscription_id');
            $table->dropColumn('suscription_token');
        });
    }
};
