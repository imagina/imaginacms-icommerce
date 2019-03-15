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
            $status['title'] = trans($status['title']);
            OrderStatus::create($status);
        }
        
    }
}
