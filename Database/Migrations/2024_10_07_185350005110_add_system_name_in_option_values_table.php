<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__option_values', function (Blueprint $table) {
    
            $table->string('system_name')->nullable()->unique()->after('option_id');
        
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

            $table->dropColumn('system_name');
            
        });
    }

};