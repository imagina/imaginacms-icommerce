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
        'total' => $this->when($this->total, $this->total),
        'total_quantity' => $this->when($this->totalquantity, $this->totalquantity),
         //Relationshps Data
        'products' => CartProductTransformer::collection($this->whenLoaded('products')),
    ];

    return $data;

    }
}
