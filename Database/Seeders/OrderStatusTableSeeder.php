<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Icommerce\Entities\OrderStatus;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $statuses = config('asgard.icommerce.config.orderStatuses');

        foreach ($statuses as $status) {
            $statusTrans = $status['title'];

            foreach (['en', 'es'] as $locale) {
                $data = [
                    'id' => $status['id'],
                    $locale => [
                        'title' => trans($status['title'], [], $locale),
                    ],
                ];
                $orderStatus = OrderStatus::find($status['id']);
                if (! isset($orderStatus->id)) {
                    $orderStatus = OrderStatus::create($data);
                }
            }//End Foreach
        }//End Foreach
    }
}
