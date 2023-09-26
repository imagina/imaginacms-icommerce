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
        Schema::table('icommerce__tax_rates', function (Blueprint $table) {
            $table->dropForeign(['tax_class_id']);
            $table->dropColumn('tax_class_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('icommerce__tax_rates', function (Blueprint $table) {
            if (! Schema::hasColumn('icommerce__tax_rates', 'tax_class_id')) {
                $table->integer('tax_class_id')->unsigned();
            }
        });
    }
};
