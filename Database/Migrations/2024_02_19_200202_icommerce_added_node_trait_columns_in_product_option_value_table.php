<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IcommerceAddedNodeTraitColumnsInProductOptionValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('icommerce__product_option_value', function (Blueprint $table) {
  
        $table->integer('lft')->unsigned()->nullable()->after('parent_prod_opt_val_id');
        $table->integer('rgt')->unsigned()->nullable()->after('parent_prod_opt_val_id');
        $table->integer('depth')->unsigned()->nullable()->after('parent_prod_opt_val_id');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
