<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class WishlistTransformer extends Resource
{
  public function toArray($request)
  {
    /*datos*/
    $item =  [
      'id' => $this->id,
      'user_id' => $this->user_id,
      'product_id' => $this->product_id,
      'product' => $this->product,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  
    if(isset($this->user))
      $item['user'] = $this->user;
  
    return $item;
  }
}