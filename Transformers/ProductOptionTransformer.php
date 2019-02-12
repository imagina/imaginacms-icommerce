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
            'option_description' => $this->option->description,
            'option_type' => $this->option->type,
            'parent_id' => $this->parent_id,
            'parent_description' =>  $this->parent ? $this->parent->description : null,
            'parent_type' =>  $this->parent ? $this->parent->type : null,
            'parent_option_value_id' => $this->parent_option_value_id,
            'value' => $this->value,
            'required' => $this->required,
        ];

        //productOptionValues
        if(isset($this->productOptionValues)){
            $data['productOptionValues']= ProductOptionValueTransformer::collection($this->whenLoaded('productOptionValues'));
        }

        return $data;
    }
}
