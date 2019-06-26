<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CartProductTransformer extends Resource
{
  public function toArray($request)
  {
    $product = $this->product()->first();
    $data = [
      'id' => $this->when($this->id, $this->id),
      'cartId' => $this->when($this->cart_id, $this->cart_id),
      'productId' => $this->when($this->product_id, $this->product_id),
      'name' => $this->when($this->name_product, $this->name_product),
      'total' => $this->when($this->total, $this->total),
      'quantity' => $this->when($this->quantity, $this->quantity),
      'mainImage' => $product->main_image,
      //Relationships Data
      'product' => $this->when($this->product, new ProductTransformer($this->product)),
      'productOptionValues' => ProductOptionValueTransformer::collection($this->productOptionValues),
    ];

    return $data;
  }
}
