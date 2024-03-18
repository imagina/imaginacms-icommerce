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
    Schema::create('icommerce__length_classes', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->double('value', 15, 8);
      $table->boolean('default')->default(false);
      // Your fields...
      
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
    Schema::dropIfExists('icommerce__length_classes');
  }
};
