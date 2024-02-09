<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Icurrency\Support\Facades\Currency;

class CartProductTransformer extends JsonResource
{
  public function toArray($request)
  {
    $product = $this->product()->first();
    $data = [
      'id' => $this->when($this->id, $this->id),
      'cartId' => $this->when($this->cart_id, $this->cart_id),
      'productId' => $this->when($this->product_id, $this->product_id),
      'warehouseId' => $this->when($this->warehouse_id, $this->warehouse_id),
      'name' => $this->when($this->name_product, $this->name_product),

      'total' => $this->when($this->total, Currency::convert($this->total)),
      'priceUnit' => $this->when($this->priceUnit, $this->priceUnit),
      'quantity' => $this->when($this->quantity, $this->quantity),
      'mainImage' => $product->main_image,
      //Relationships Data
      'product' => $this->when($this->product, new ProductTransformer($this->product)),
      'productOptionValues' => ProductOptionValueTransformer::collection($this->productOptionValues),
    ];

    return $data;
  }
}
