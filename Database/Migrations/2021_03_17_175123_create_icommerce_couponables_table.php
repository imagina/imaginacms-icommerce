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
        Schema::create('icommerce__couponables', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('coupon_id')->unsigned();
            $table->integer('couponable_id')->unsigned();
            $table->string('couponable_type');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('icommerce__couponables');
    }
};
