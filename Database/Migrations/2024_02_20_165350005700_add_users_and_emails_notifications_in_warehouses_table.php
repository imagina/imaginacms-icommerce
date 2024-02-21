<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersAndEmailsNotificationsInWarehousesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {

    Schema::table('icommerce__warehouses', function (Blueprint $table) {
    
      $table->text('users_to_notify')->after('polygon_id')->nullable();
      $table->text('emails_to_notify')->after('users_to_notify')->nullable();
  
    });

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {

    Schema::table('icommerce__warehouses', function (Blueprint $table) {

      $table->dropColumn('users_to_notify');
      $table->dropColumn('emails_to_notify');

    });

  }

}
