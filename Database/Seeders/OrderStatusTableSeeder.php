<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\ItemType;
use Modules\Icommerce\Entities\OrderStatus;
use Modules\Icommerce\Entities\OrderStatusTranslation;

class OrderStatusTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    
    $statuses = config('asgard.icommerce.config.orderStatuses');
    
    foreach ($statuses as $status) {
      
      $statusTrans = $status['title'];
      
      foreach (['en', 'es'] as $locale) {
  
        $data = [
          "id" => $status['id'],
          $locale => [
            "title" => $status['title'],
          ]
        ];
        $orderStatus = OrderStatus::find($status['id']);
        if(isset($orderStatus->id)){
          $orderStatus->update($data);
        }else{
          $orderStatus = OrderStatus::create($data);
        }
        
      }//End Foreach
    }//End Foreach
    
    
  }
}
