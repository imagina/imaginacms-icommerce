<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CartProductOptionTransformer extends Resource
{
    public function toArray($request)
    {
        $data =  [
            'id' => $this->when($this->pivot->id, $this->pivot->id),
            'cartProductId' => $this->when($this->pivot->cart_product_id, $this->pivot->cart_product_id),
            'productOptionId' => $this->when($this->pivot->product_option_id, $this->pivot->product_option_id),
            'productOptionValueId' => $this->when($this->pivot->product_option_value_id, $this->pivot->product_option_value_id),
            'productOptionValuePrice' => $this->price,

        ];
        return $data;
    }
}
