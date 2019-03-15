<?php

namespace Modules\Icommerce\Support;

class OrderOption
{

  public function fixData($orderID,$orderItemID){

    $data = array(
        'order_id' => $orderID, 
        'order_item_id' => $orderItemID,
        'parent_option_value' => "1",
        'option_value' => "1",
        'price' => 1,
        'price_prefix' => 'pre',
        'points' => 1,
        'points_prefix' => 'pre',
        'weight' => '1',
        'points_prefix' => 'pre',
        'value' => 'value',
        'required' => 'xx'
    );

    return $data;
    

  }


}