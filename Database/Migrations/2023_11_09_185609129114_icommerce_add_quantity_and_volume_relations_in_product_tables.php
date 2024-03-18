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
      Schema::table('icommerce__products', function (Blueprint $table) {
        $table->integer("volume_class_id")->unsigned()->after("length_class_id")->nullable();
        $table->foreign('volume_class_id')->references('id')->on('icommerce__volume_classes')->onDelete('restrict');
        $table->decimal('volume')->nullable()->after("length_class_id")->default(0)->unsigned();
        $table->integer("quantity_class_id")->unsigned()->after("quantity")->nullable();
        $table->foreign('quantity_class_id')->references('id')->on('icommerce__quantity_classes')->onDelete('restrict');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
