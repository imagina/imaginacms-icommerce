<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CartProductTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
        'id' => $this->id,
        'product_id' => $this->id,

        'price' => $this->price,
        'subtotal' => $this->SubTotal,
        'quantity' => $this->quantity,
    ];

    return $data;
  }
}
