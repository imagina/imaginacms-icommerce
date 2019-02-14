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
            'selected' => '',
        ];

        //productOptionValues
        if(isset($this->productOptionValues)){
            $fiters = json_decode($request->input('filter'));
            if (isset($fiters->parentOptionValueId)){
                $data['productOptionValues']= ProductOptionValueTransformer::collection($this->whenLoaded('productOptionValues'))->where('parent_option_value_id', $fiters->parentOptionValueId);
            } else {
                $data['productOptionValues']= ProductOptionValueTransformer::collection($this->whenLoaded('productOptionValues'));
            }
        }

        return $data;
    }
}
