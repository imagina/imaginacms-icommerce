<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('icommerce__product_option', function (Blueprint $table) {
      $table->text('options')->nullable()->after('required');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('icommerce__product_option', function (Blueprint $table) {
      $table->dropColumn('options');
    });
  }
};
