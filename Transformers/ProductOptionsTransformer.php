<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ProductOptionsTransformer extends Resource
{
    public function toArray($request)
    {
        $option_values=[];
        if(isset($this->product_option_values) && !empty($this->product_option_values)){
          foreach($this->product_option_values as $option_value){
            $options_value_options=json_decode($option_value->option_value->options);
            if((int)$option_value->product_id==(int)$this->pivot->product_id){
              if (isset($options_value_options->image) && !empty($options_value_options->image)) {
                $options_value_options->image = url($options_value_options->image);
              }
              $option_values[]=[
                'id'=>$option_value->option_value_id,
                'product_option_value_id'=>$option_value->id,
                'option_id'=>$option_value->option_id,
                'product_option_id'=>$option_value->product_option_id,
                'description'=>$option_value->option_value->description,
                'type'=>$option_value->option_value->type,
                'option'=>$options_value_options,
                'price' => $option_value->price,
                'price_prefix' => $option_value->price_prefix,
                'quantity'=>$option_value->quantity,
                'subtract'=>$option_value->subtract,
                'weigth'=>$option_value->weight,
                'weight_prefix'=>$option_value->weight_prefix,
              ];
            }//if product option value == product option pivot
          }//foreach
        }
        return  [
            'option_id' => $this->id,
            'required' => $this->pivot->required,
            'type' => $this->type,
            'description' => $this->description,
            'option_product_id'=>$this->pivot->product_id,
            'product_option_id'=>$this->pivot->id,
            'option_values'=>$option_values
        ];
    }
}
