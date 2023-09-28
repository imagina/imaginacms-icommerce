<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Icommerce\Entities\OrderStatus;

class IcommerceFixOrdersStatusPendingDuplicatedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $orderStatusPending = OrderStatus::find(11);

        if (isset($orderStatusPending->id) && in_array($orderStatusPending->title, ['Pendiente', 'Pending'])) {
            foreach (['en', 'es'] as $locale) {
                $data = [
                    'id' => $orderStatusPending->id,
                    $locale => [
                        'title' => trans('icommerce::orderstatuses.statuses.confirmingPayment', [], $locale),
                    ],
                ];
                $orderStatusPending->update($data);
            }
        }//End Foreach
    }
}
