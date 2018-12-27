<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CartProductTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'price' => $this->price,
      'quantity' => $this->quantity,
      'options' => $this->options,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
    
    return $data;
  }
}