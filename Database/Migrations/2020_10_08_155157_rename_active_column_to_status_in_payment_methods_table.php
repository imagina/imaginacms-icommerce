<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameActiveColumnToStatusInPaymentMethodsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    try{
      Schema::table('icommerce__payment_methods', function (Blueprint $table) {
        $table->renameColumn('active', 'status');
      });
    }catch(\Exception $e){
      \Log::info(" There is no column with name 'status' on table 'icommerce__payment_methods'");
    }
    
  }
  
  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
  
  }
}
