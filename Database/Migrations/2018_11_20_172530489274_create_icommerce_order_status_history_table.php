<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('icommerce__order_status_history', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('icommerce__orders')->onDelete('restrict');

            $table->tinyInteger('status')->default(1)->unsigned();
            $table->integer('notify')->unsigned();
            $table->text('comment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('icommerce__order_status_history');
    }
};
