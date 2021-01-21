<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Notification\Entities\Rule;
class NotificationRulesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    
    $orderWasCreated = Rule::whereRaw("(replace(event_path, '\\\\', '') like '%Modules\Icommerce\Events\OrderWasCreated%')")
      ->where("entity_name","Modules\Icommerce\Entities\Order")->first();

    if(!isset($orderWasCreated->id)){
      Rule::create([
        "name" => "Order was created",
        "entity_name" => "Modules\Icommerce\Entities\Order",
        "event_path" => "Modules\Icommerce\Events\OrderWasCreated",
        "status" => true,
        "settings" => [
          "email" => ["status" => 1,"recipients" => [],"template" => null],
          "pusher" => ["status" => 0,"saveInDatabase" => 1,"recipients" => []]
        ],
      ]);
    }
 
  }
}
