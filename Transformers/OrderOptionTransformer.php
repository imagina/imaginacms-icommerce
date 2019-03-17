<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class OrderOptionTransformer extends Resource
{
  public function toArray($request)
  {

    $item =  [
      'id' => $this->when($this->id,$this->id),
      'order_id' => $this->when($this->order_id,$this->order_id),
      'order_item_id' => $this->when($this->order_item_id,$this->order_item_id),
      'parent_option_value' => $this->when($this->parent_option_value,$this->parent_option_value),
      'option_value' => $this->when($this->option_value,$this->option_value),
      'price' => $this->when($this->price,$this->price),
      'price_prefix' => $this->when($this->price_prefix,$this->price_prefix),
      'points' => $this->when($this->points,$this->points),
      'points_prefix' => $this->when($this->points_prefix,$this->points_prefix),
      'weight' => $this->when($this->weight,$this->weight),
      'weight_prefix' => $this->when($this->weight_prefix,$this->weight_prefix),
      'value' => $this->when($this->value,$this->value),
      'required' => $this->when($this->required,$this->required),
      'created_at' => $this->when($this->created_at,$this->created_at),
      'updated_at' => $this->when($this->updated_at,$this->updated_at)
    ];
  
    return $item;

  }
}