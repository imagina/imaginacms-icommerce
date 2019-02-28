<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CartProductOptionTransformer extends Resource
{
    public function toArray($request)
    {
    $data =  [
        'id' => $this->when($this->id, $this->id),
        'cart_product_id' => $this->when($this->cart_product_id, $this->cart_product_id),
        'product_option_id' => $this->when($this->product_option_id, $this->product_option_id),
        'product_option_value_id' => $this->when($this->product_option_value_id, $this->product_option_value_id),
    ];
    return $data;
    }
}
