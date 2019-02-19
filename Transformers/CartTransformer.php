<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CartTransformer extends Resource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'ip' => $this->ip,
      'user_id' => $this->user_id,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];

    // Products
    if(isset($this->products))
        $products = CartProductTransformer::collection($this->products);
        $data['products'] = $products;
        $data['products_cant'] = $products->count();

    // User
    if(isset($this->user))
      $data['user'] = $this->user;

    return $data;
  }
}
