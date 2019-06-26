<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class OrderHistoryTransformer extends Resource
{
  public function toArray($request)
  {

    $item =  [
      'id' => $this->when($this->id,$this->id),
      'status' => $this->when($this->orderStatus,$this->orderStatus),
      'notify' => $this->when($this->notify,$this->notify),
      'comment' => $this->when($this->comment,$this->comment),
      'created_at' => $this->when($this->created_at,$this->created_at),
      'updated_at' => $this->when($this->updated_at,$this->updated_at)
    ];
  
    return $item;

  }
}