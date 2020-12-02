<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\Store;

class StoreTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    
    $default = Store::where("name","Default")->first();
    
    if(!isset($default->id))
      Store::create([
          'name'=>'Default',
          'address'=>'N/a',
          'phone'=>'00000000',
        
      ]);
    
  }
}
