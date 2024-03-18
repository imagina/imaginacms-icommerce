<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Icommerce\Entities\LengthClass;
use Modules\Icommerce\Entities\WeightClass;


class WeightAndLengthTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
  
    $seedUniquesUse = DB::table('isite__seeds')->where("name", 'WeightAndLengthTableSeeder')->first();
  
    if(empty($seedUniquesUse)) {
      \DB::beginTransaction();
      try {
        $weightClasses = config("asgard.icommerce.config.weightClasses");
        $lengthClasses = config("asgard.icommerce.config.lengthClasses");
        
        foreach ($weightClasses as $weightClass){
          WeightClass::create($weightClass);
        }
        foreach ($lengthClasses as $lengthClass){
          LengthClass::create($lengthClass);
        }
        
        
        \DB::commit();
        DB::table('isite__seeds')->insert(['name' => 'WeightAndLengthTableSeeder']);
      } catch (\Exception $e) {
        \DB::rollback();//Rollback to Data Base
        \Log::Error($e);
      }
     
    }
  }
}
