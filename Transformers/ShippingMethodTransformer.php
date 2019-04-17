<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ShippingMethodTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->when($this->id,$this->id),
      'title' => $this->when($this->title,$this->title),
      'description' => $this->when($this->description,$this->description),
      'name' => $this->when($this->name,$this->name),
      'status' => $this->when($this->status,$this->status),
      'options' => $this->when($this->options,$this->options),
      'created_at' => $this->when($this->created_at,$this->created_at),
      'updated_at' => $this->when($this->updated_at,$this->updated_at),
    ];

    // It's not a relation
    if (isset($this->calculations)) {
      $item['calculations']= $this->calculations;
    }


  
    return $item;
  }
}