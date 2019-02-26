<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CartTransformer extends Resource
{
  public function toArray($request)
  {

      $data = [
          'id' => $this->when($this->id, $this->id),
          'ip' => $this->when($this->ip, $this->ip),
          'user_id' => $this->when($this->user_id, $this->user_id),
          'created_at' => $this->when($this->created_at, $this->created_at),
          'updated_at' => $this->when($this->updated_at, $this->updated_at),
          'products' => CartProductTransformer::collection($this->whenLoaded('products')),
          'total' => $this->total,
      ];

      return $data;





    //
    //is->id,
    //is->ip,
    //> $this->user_id,
    //' => $this->created_at,
    //' => $this->updated_at,
    //

    //
    //s->products))
    //oducts']= AddressTransformer::collection($this->whenLoaded('addresses'));
    //oducts'] = $this->products;

    //
    //

    //
    //s->user))
    //'] = $this->user;

    //



  }
}
