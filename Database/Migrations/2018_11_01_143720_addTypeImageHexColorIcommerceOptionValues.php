<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeImageHexColorIcommerceOptionValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('icommerce__option_values', function (Blueprint $table) {
          $table->string('type');
          $table->text('options')->default('')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('icommerce__option_values', function (Blueprint $table) {
          $table->dropColumn('type');
          $table->dropColumn('options');
      });
    }
}
