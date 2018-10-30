<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ProductOptionsTransformer extends Resource
{
    public function toArray($request)
    {
      /*valida la imagen del producto*/
      if (isset($this->option_value->image) && !empty($this->option_value->image)) {
          $image = url($this->option_value->image);
      } else {
          $image = url('modules/icommerce/img/product/default.jpg');
      }
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
            // 'image'=>$image,
            'option_description'=>$this->option_value->description,
            'option_value_id'=>$this->option_value->id
        ];
    }
}
