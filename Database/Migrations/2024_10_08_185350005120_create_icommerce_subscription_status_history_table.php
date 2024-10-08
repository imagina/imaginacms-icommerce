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
        Schema::create('icommerce__subscription_status_history', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your fields...
            $table->integer('subscription_id')->unsigned();
            $table->foreign('subscription_id')->references('id')->on('icommerce__subscriptions')->onDelete('restrict');
    
            $table->tinyInteger('status_id')->default(0)->unsigned();
            $table->integer('notify')->default(0)->unsigned();
            $table->text('comment')->nullable();

            // Audit fields
            $table->timestamps();
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('icommerce__subscription_status_history');
    }

};