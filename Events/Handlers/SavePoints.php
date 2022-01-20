<?php

namespace Modules\Icommerce\Events\Handlers;


class SavePoints
{

   
    public function handle($event = null)
    {
       
      //\Log::info('Icommerce|Handler|SavePoints');

      if(is_module_enabled('Ipoint')){

        $order = $event->order;
        $moneyForPoint = setting('ipoint::moneyForPoint',null,0);

        if($moneyForPoint>0){

          $points = $order->total / $moneyForPoint;
         
          if(setting('ipoint::roundPoints',null,false))
            $points = round($points);
          else
            $points = floor($points);
      
          // Data to Save
          $data = [
            'user_id' => $order->customer_id,
            'description' => 'Puntos por orden #'.$order->id,
            'points' => $points
          ];

          // Create Point
          $pointCreated = app("Modules\Ipoint\Services\PointService")->create($order,$data);

        }

      }// Validation If Module

    }
    
}