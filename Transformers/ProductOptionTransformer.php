<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ProductOptionTransformer extends Resource
{
    public function toArray($request)
    {
        //Transformer only data base
        $data =  [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'option_id' => $this->option_id,
            'parent_id' => $this->parent_id,
            'parent_option_value_id' => $this->parent_option_value_id,
            'value' => $this->value,
            'required' => $this->required
        ];
        return $data;
    }
}
