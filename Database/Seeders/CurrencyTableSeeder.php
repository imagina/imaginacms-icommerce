<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\Currency;
use Modules\Icommerce\Entities\ItemType;
use Modules\Icommerce\Entities\OrderStatus;

class CurrencyTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    
    Currency::create([
      "code"	=> "COP",
      "symbol_left"	=> "$",
      "symbol_right"	=> "",
      "decimal_place"=> "",
      "value"	=> 1,
      "status"	=> 1,
      "default_currency"	=> true
      
    ]);
    
  }
}
