<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        \DB::statement('ALTER TABLE icommerce__product_translations ADD FULLTEXT full(name)');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    }
};
