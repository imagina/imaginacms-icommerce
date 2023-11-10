<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Icommerce\Entities\LengthClass;
use Modules\Icommerce\Entities\QuantityClass;
use Modules\Icommerce\Entities\VolumeClass;
use Modules\Icommerce\Entities\WeightClass;


class VolumeAndQuantityTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
  
    $seedUniquesUse = DB::table('isite__seeds')->where("name", 'VolumeAndQuantityTableSeeder')->first();
  
    if(empty($seedUniquesUse)) {
      \DB::beginTransaction();
      try {
        $volumeClasses = config("asgard.icommerce.config.volumeClasses");
        $quantityClasses = config("asgard.icommerce.config.quantityClasses");
        
        foreach ($volumeClasses as $volumeClass){
          VolumeClass::create($volumeClass);
        }
        foreach ($quantityClasses as $quantityClass){
          QuantityClass::create($quantityClass);
        }
        
        
        \DB::commit();
        DB::table('isite__seeds')->insert(['name' => 'VolumeAndQuantityTableSeeder']);
      } catch (\Exception $e) {
        \DB::rollback();//Rollback to Data Base
        \Log::Error($e);
      }
     
    }
  }
}
