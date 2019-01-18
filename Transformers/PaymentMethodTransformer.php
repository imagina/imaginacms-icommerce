<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class PaymentMethodTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->id,
      'title' => $this->title,
      'description' => $this->description,
      'name' => $this->name,
      'status' => $this->status,
      'image' => $this->options->mainimage,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  
    return $item;
  }
}