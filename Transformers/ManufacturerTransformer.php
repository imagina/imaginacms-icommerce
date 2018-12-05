<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ManufacturerTransformer extends Resource
{
  public function toArray($request)
  {
    return  [
      'id' => $this->id,
      'name' => $this->name,
      'status' => $this->status,
      'options' => $this->options,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  }
}