<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\OrderStatus;

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

                if($locale=='en'){
                    $status['title'] = trans($statusTrans,[],$locale);
                    $orderStatus = OrderStatus::create($status);
                }else{
                    $title = trans($statusTrans,[],$locale);
                    $orderStatus->translateOrNew($locale)->title = $title;
                    $orderStatus->save();
                }
                
            }//End Foreach
        }//End Foreach
        
    }
}
