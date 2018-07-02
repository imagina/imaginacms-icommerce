<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icommerce__coupons', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields

            $table->text('name');
            $table->string('code');
            $table->char('type', 1);
            $table->float('discount', 8, 2);
            $table->tinyInteger('logged')->unsigned();
            $table->tinyInteger('shipping')->unsigned();
            $table->float('total', 8, 2);
            $table->date('datestart');
            $table->date('dateend');
            $table->integer('uses_total')->unsigned();
            $table->tinyInteger('status')->default(0)->unsigned();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('icommerce__coupons');
    }
}
