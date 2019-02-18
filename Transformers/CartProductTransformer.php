<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CartProductTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->pivot->id,
        'product_id' => $this->id,
       'name' => $this->name,
       'price' => $this->price,
        'subtotal' => $this->price * $this->pivot->quantity,
      'quantity' => $this->pivot->quantity,
    ];

    return $data;
  }
}
