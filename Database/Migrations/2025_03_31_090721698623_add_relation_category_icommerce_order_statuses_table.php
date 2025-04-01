<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationCategoryIcommerceOrderStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('icommerce__order_statuses', function (Blueprint $table) {

          $table->integer('category_id')->unsigned()->nullable()->after('color');
          $table->foreign('category_id')->references('id')->on('icommerce__order_status_categories')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

      Schema::table('icommerce__order_statuses', function (Blueprint $table) {
        $table->dropForeign(['category_id']);
        $table->dropColumn('category_id');
      });

    }

}
