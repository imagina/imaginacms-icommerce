<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Icurrency\Support\Facades\Currency;

class ProductListTransformer extends Resource
{
  public function toArray($request)
  {
    $item = [
      'id' => $this->id,
      'product_id' => $this->product_id,
      'price_list_id' => $this->price_list_id,
      'product_option_value_id' => $this->product_option_value_id,
      'price' => $this->when($this->price, Currency::convert($this->price)),
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  
    if(isset($this->product))
      $item['product'] = $this->product;
    
  
    if(isset($this->productOptionValue))
      $item['productOptionValue'] = $this->productOptionValue;
    
    return $item;
  }
}