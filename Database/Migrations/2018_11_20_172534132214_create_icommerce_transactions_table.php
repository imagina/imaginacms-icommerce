<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceTransactionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__transactions', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields
  
      $table->string('external_id')->nullable();
      $table->integer('order_id')->unsigned();
      $table->foreign('order_id')->references('id')->on('icommerce__orders')->onDelete('restrict');
  
      $table->integer('payment_method_id')->unsigned();
      $table->foreign('payment_method_id')->references('id')->on('icommerce__payment_methods')->onDelete('restrict');
  
      $table->decimal('amount', 20, 2);
      $table->integer('status')->unsigned();
      $table->integer('external_status')->unsigned();
      
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
    Schema::dropIfExists('icommerce__transactions');
  }
}
