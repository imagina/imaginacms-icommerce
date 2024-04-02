<?php

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
        Schema::create('icommerce__warehouse_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->text('title');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();

            $table->integer('warehouse_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['warehouse_id', 'locale']);
            $table->foreign('warehouse_id')->references('id')->on('icommerce__warehouses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('icommerce__warehouse_translations', function (Blueprint $table) {
            $table->dropForeign(['warehouse_id']);
        });
        Schema::dropIfExists('icommerce__warehouse_translations');
    }
};
