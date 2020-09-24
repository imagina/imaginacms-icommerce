<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFulltextIndiceInProductTranslationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    \DB::statement("ALTER TABLE icommerce__product_translations ADD FULLTEXT full(name)");
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
