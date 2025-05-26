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

    $seedUniquesUse = \DB::table('isite__seeds')->where('name', 'OrderStatusTableSeeder')->first();
    if (empty($seedUniquesUse)) {

      $statuses = config('asgard.icommerce.config.orderStatuses');

      foreach ($statuses as $status) {
        $translatedTitles = [
          'en' => trans($status['title'], [], 'en'),
          'es' => trans($status['title'], [], 'es'),
        ];

        $data = [
          'id' => $status['id'],
          'en' => [
            'title' => $translatedTitles['en'],
          ],
          'es' => [
            'title' => $translatedTitles['es'],
          ],
        ];

        $orderStatus = OrderStatus::find($status['id']);

        if (!isset($orderStatus->id)) {
          OrderStatus::create($data);
        } else {
          $orderStatus->update($data);
        }
      }
      \DB::table('isite__seeds')->insert(['name' => 'OrderStatusTableSeeder']);
    }
  }
}
