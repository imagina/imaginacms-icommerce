<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Icommerce\Transformers\OrderOptionTransformer;

class OrderItemTransformer extends Resource
{
  public function toArray($request)
  {

    $item =  [
      'id' => $this->when($this->id,$this->id),
      'order_id' => $this->when($this->order_id,$this->order_id),
      'product_id' => $this->when($this->product_id,$this->product_id),
      'item_type_id' => $this->when($this->item_type_id,$this->item_type_id),
      'title' => $this->when($this->title,$this->title),
      'reference' => $this->when($this->reference,$this->reference),
      'quantity' => $this->when($this->quantity,$this->quantity),
      'price' => $this->when($this->price,$this->price),
      'total' => $this->when($this->total,$this->total),
      'created_at' => $this->when($this->created_at,$this->created_at),
      'updated_at' => $this->when($this->updated_at,$this->updated_at)
    ];

    if(isset($this->orderOption) && count($this->orderOption)>0)
      $item['options'] = OrderOptionTransformer::collection($this->orderOption);
  
    return $item;

  }
}