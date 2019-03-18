<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class PaymentMethodTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->when($this->id,$this->id),
      'title' => $this->when($this->title,$this->title),
      'description' => $this->when($this->description,$this->description),
      'name' => $this->when($this->name,$this->name),
      'status' => $this->when($this->status,$this->status),
      'image' => $this->when($this->options->mainimage,$this->options->mainimage),
      'created_at' => $this->when($this->created_at,$this->created_at),
      'updated_at' => $this->when($this->updated_at,$this->updated_at)
    ];
  
    return $item;
  }
}