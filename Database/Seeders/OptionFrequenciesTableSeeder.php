<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Modules\Icommerce\Entities\Option;
use Modules\Icommerce\Entities\OptionValue;


class OptionFrequenciesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    
    \DB::beginTransaction();
    try {

      //Process Option
      $option = Option::where("group","payment-frequency")->first();
      if(!isset($option->id)){
        //Create Option Base
        $optionData = config("asgard.icommerce.config.option-frequencies.option");
        $option = Option::create($optionData);
      }

      //Process Option Values (Frequencies)
      $frenquencies = config("asgard.icommerce.config.option-frequencies.frequencies");

      if(!is_null($frenquencies) && !is_null($option)){
        foreach ($frenquencies as $frequency){
          $optionValue = OptionValue::where("system_name",$frequency['system_name'])->first();
          //Create Option Value
          if(!isset($optionValue->id)){
            $frequency['option_id'] = $option->id; 
            OptionValue::create($frequency);
          }
        }
      }

      \DB::commit();
      
    } catch (\Exception $e) {
      \DB::rollback();
      \Log::Error($e);
    }

  }


}
