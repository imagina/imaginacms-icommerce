<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ShippingMethodTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->id,
      'title' => $this->title,
      'description' => $this->description,
      'name' => $this->name,
      'status' => $this->status,
      'options' => $this->options,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];

    if (isset($this->calculations)) {
      $item['calculations']= $this->calculations;
    }


  
    return $item;
  }
}