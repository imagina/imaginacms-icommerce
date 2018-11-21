<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class OptionValueTransformer extends Resource
{
    public function toArray($request)
    {
        $option_value="";
        $option=json_decode($this->options);
        if($this->type=="image"){
          if (isset($option->image) && !empty($option->image)) {
            $option_value = url($option->image);
          } else {
            $option_value = url('modules/icommerce/img/product/default.jpg');
          }
        }else if($this->type=="text"){
          $option_value=$option->text;
        }else if($this->type=="background"){
          $option_value=$option->background;
        }
        return  [
            'id' => $this->id,
            'type' => $this->type,
            'description' => $this->description,
            'option'=>$option_value
        ];
    }
}
