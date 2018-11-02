<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ProductOptionsTransformer extends Resource
{
    public function toArray($request)
    {
      /*valida la imagen del producto*/
      $options_value_options=json_decode($this->option_value->options);
      if (isset($options_value_options->image) && !empty($options_value_options->image)) {
          $options_value_options->image = url($options_value_options->image);
      }
      // else {
      //     $image = url('modules/icommerce/img/product/default.jpg');
      // }
        return  [
            'product_option_values_id' => $this->id,
            'points' => $this->points,
            'points_prefix' => $this->points_prefix,
            'price' => $this->price,
            'price_prefix' => $this->price_prefix,
            'quantity'=>$this->quantity,
            'subtract'=>$this->subtract,
            'weigth'=>$this->weight,
            'weight_prefix'=>$this->weight_prefix,
            'option'=>$this->option->description,
            'option_description'=>$this->option_value->description,
            'option_value_id'=>$this->option_value->id,
            'option_value_options'=>$options_value_options
        ];
    }
}
