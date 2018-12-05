<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class CouponTransformer extends Resource
{
  public function toArray($request)
  {
    /*datos*/
    return  [
      'id' => $this->id,
      'name' => $this->name,
      'code' => $this->code,
      'type' => $this->type,
      'discount' => $this->discount,
      'logged' => $this->logged,
      'shipping' => $this->shipping,
      'total' => $this->total,
      'date_start' => $this->date_start,
      'date_end' => $this->date_end,
      'uses_total' => $this->uses_total,
      'status' => $this->status,
      'options' => $this->options,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
      
    ];
  }
}