<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CartTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->id,
      'name' => $this->name,
      'payment_code' => $this->payment_code,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  
    return $item;
  }
}