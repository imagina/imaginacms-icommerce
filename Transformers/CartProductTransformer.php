<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CartProductTransformer extends Resource
{
    public function toArray($request)
    {
      $product = $this->product()->first();
        $data =  [
            'id' => $this->when($this->id, $this->id),
            'cart_id' => $this->when($this->cart_id, $this->cart_id),
            'product_id' => $this->when($this->product_id, $this->product_id),
            'name' => $this->when($this->nameproduct, $this->nameproduct),
            'price' => $this->when($this->price, $this->price),
            'unitary_price' => $this->when($product->price, $product->price),
            'subtotal' => $this->when($this->SubTotal, $this->SubTotal),
            'quantity' => $this->when($this->quantity, $this->quantity),
            'mainImage' => $product->main_image,
            //Relationshps Data
            'options' => CartProductOptionTransformer::collection($this->whenLoaded('cartproductoption')),
        ];

    return $data;
    }
}
