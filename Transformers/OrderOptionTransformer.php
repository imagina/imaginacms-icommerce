<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class OrderOptionTransformer extends Resource
{
  public function toArray($request)
  {

    $item =  [
      'id' => $this->when($this->id,$this->id),
      'orderId' => $this->when($this->order_id,$this->order_id),
      'order' => new OrderTransformer($this->whenLoaded('order')),
      'orderItemId' => $this->when($this->order_item_id,$this->order_item_id),
      'optionDescription' => $this->when($this->option_description,$this->option_description),
      'optionValueDescription' => $this->when($this->option_value_description,$this->option_value_description),
      'price' => $this->when($this->price,$this->price),
      'pricePrefix' => $this->when($this->price_prefix,$this->price_prefix),
      'points' => $this->when($this->points,$this->points),
      'pointsPrefix' => $this->when($this->points_prefix,$this->points_prefix),
      'weight' => $this->when($this->weight,$this->weight),
      'weightPrefix' => $this->when($this->weight_prefix,$this->weight_prefix),
      'value' => $this->when($this->value,$this->value),
      'required' => $this->when($this->required,$this->required),
      'createdAt' => $this->when($this->created_at,$this->created_at),
      'updatedAt' => $this->when($this->updated_at,$this->updated_at)
    ];
  
    return $item;

  }
}