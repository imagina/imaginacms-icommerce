<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\ItemType;
use Modules\Icommerce\Entities\ItemTypeTranslation;
use Modules\Icommerce\Entities\OrderStatus;

class ItemTypeTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    
    $itemTypes = config('asgard.icommerce.config.itemTypes');
    
    foreach ($itemTypes as $type) {
      
      $statusTrans = $type['title'];
      
      foreach (['en', 'es'] as $locale) {
  
        $data = [
          "id" => $type['id'],
          $locale => [
            "title" => $type['title'],
          ]
        ];
        $itemType = ItemType::find($type['id']);
        if(isset($itemType->id)){
          $itemType->update($data);
        }else{
          $itemType = ItemType::create($data);
        }
        
      }//End Foreach
    }//End Foreach
    
  }
}
