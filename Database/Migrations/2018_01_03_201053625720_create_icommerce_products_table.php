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
            $table->text('title');
            $table->string('slug');
            $table->text('description');
            $table->text('summary');
            $table->text('options')->default('')->nullable();
            $table->tinyInteger('status')->default(0)->unsigned();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on(config('auth.table', 'users'))->onDelete('restrict');

            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('icommerce__categories')->onDelete('restrict');

            $table->integer('parent_id')->default(0)->unsigned();
            
            $table->text('related_ids')->default('')->nullable();
            $table->string('sku')->nullable();
            $table->integer('quantity')->default(0)->unsigned();
            $table->tinyInteger('stock_status')->default(0)->unsigned();
            $table->integer('manufacter_id')->unsigned()->nullable();
            $table->foreign('manufacter_id')->references('id')->on('icommerce__manufacturers')->onDelete('restrict');

            $table->tinyInteger('shipping')->default(1)->unsigned();
            $table->float('price', 8, 2)->default(0);
            $table->integer('points')->default(0)->unsigned();
            $table->date('date_available')->nullable();
            $table->float('weight', 8, 2)->nullable();
            $table->float('lenght', 8, 2)->nullable();
            $table->float('width', 8, 2)->nullable();
            $table->float('height', 8, 2)->nullable();
            $table->tinyInteger('substract')->default(1)->unsigned();
            $table->integer('minimum')->default(1)->unsigned();
            $table->string('reference')->nullable();
            $table->text('rating')->default('')->nullable();

            $table->tinyInteger('freeshipping')->default(0)->unsigned();

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

