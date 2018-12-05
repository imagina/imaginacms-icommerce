<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcommerceProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('icommerce__products', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      // Your fields

      
      $table->text('options')->default('')->nullable();
      $table->tinyInteger('status')->default(0)->unsigned();
      
      $table->integer('added_by_id')->unsigned();
      $table->foreign('added_by_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');
  
      $table->integer('category_id')->unsigned()->nullable();
      $table->foreign('category_id')->references('id')->on('icommerce__categories')->onDelete('restrict');
  
      
      $table->integer('parent_id')->default(0)->unsigned();
      
      $table->text('related_ids')->default('')->nullable();
  
      $table->integer('tax_class_id')->unsigned()->nullable();
      $table->foreign('tax_class_id')->references('id')->on('icommerce__tax_classes')->onDelete('restrict');
  
      $table->string('sku')->nullable();
      $table->integer('quantity')->default(0)->unsigned();
      $table->tinyInteger('stock_status')->default(0)->unsigned();
      $table->integer('manufacturer_id')->unsigned()->nullable();
      $table->foreign('manufacturer_id')->references('id')->on('icommerce__manufacturers')->onDelete('restrict');
      
      $table->tinyInteger('shipping')->default(1)->unsigned();
      $table->double('price', 30, 2)->default(0);
      $table->integer('points')->default(0)->unsigned();
      $table->date('date_available')->nullable();
      $table->float('weight', 8, 2)->nullable();
      $table->float('length', 8, 2)->nullable();
      $table->float('width', 8, 2)->nullable();
      $table->float('height', 8, 2)->nullable();
      $table->tinyInteger('subtract')->default(1)->unsigned();
      $table->integer('minimum')->default(1)->unsigned();
      $table->string('reference')->nullable();
      $table->text('rating')->default('')->nullable();
      $table->integer('order_weight')->nullable();
      $table->boolean('freeshipping')->default(false)->unsigned();
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
    Schema::dropIfExists('icommerce__products');
  }
}
