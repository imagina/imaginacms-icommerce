<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CartTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'total' => $this->total,
      'ip' => $this->ip,
      'user_id' => $this->user_id,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  
    // Products
    if(isset($this->products))
      $data['products'] = $this->products;

    
    // User
    if(isset($this->user))
      $data['user'] = $this->user;
  
    return $data;
  }
}