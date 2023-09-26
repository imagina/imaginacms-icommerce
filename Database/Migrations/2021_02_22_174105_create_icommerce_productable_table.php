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
        Schema::create('icommerce__productable', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('productable_type');
            $table->integer('productable_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->index(['productable_type', 'productable_id'], 'productable_type_id_foreign');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('icommerce__productable');
    }
};
