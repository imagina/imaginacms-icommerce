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
            'option' => $this->option,
            'option_values' => $this->option->optionValues,
            'parent_id' => $this->parent_id,
            'parent' => $this->parent,
            'parent_value' => $this->parent,
            'parent_option_value_id' => $this->parent_option_value_id,
            'value' => $this->value,
            'required' => $this->required,
            'product_option_values' => $this->productOptionValues,
        ];
        return $data;
    }
}
