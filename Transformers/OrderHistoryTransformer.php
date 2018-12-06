<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class OrderHistoryTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->id,
      'order_id' => $this->order_id,
      'status' => $this->status,
      'notify' => $this->notify,
      'comment' => $this->comment,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,

    ];
  
    // Order
    if(isset($this->order))
      $item['order'] = $this->order;
    
  
    return $item;
  }
}