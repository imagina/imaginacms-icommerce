<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CartTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->id,
      'total' => $this->total,
      'ip' => $this->ip,
      'user_id' => $this->user_id,
      'products' => $this->products,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  
    // User
    if(isset($this->user))
      $item['user'] = $this->user;
  
    return $item;
  }
}