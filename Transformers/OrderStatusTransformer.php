<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class OrderStatusTransformer extends Resource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->id,
      'title' => $this->title,
      'parent_id' => $this->parent_id,
      'status' => $this->status,
  ];
    return $item;
  }
}