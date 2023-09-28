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
        Schema::table('icommerce__options', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('icommerce__option_values', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('icommerce__product_option', function (Blueprint $table) {
            $table->auditStamps();
        });
        Schema::table('icommerce__product_option_value', function (Blueprint $table) {
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
