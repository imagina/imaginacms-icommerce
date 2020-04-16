<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;


class ProductDiscountTransformer extends Resource
  {
  public function toArray($request)
    {
      $data = [
        'id' => $this->when($this->id, $this->id),
        'productId' => $this->when($this->product_id, $this->product_id),
        'productOptionId' => $this->when($this->product_option_id, $this->product_option_id),
        'productOptionValueId' => $this->when($this->product_option_value_id, $this->product_option_value_id),
        'quantity' => $this->when($this->quantity, $this->quantity),
        'priority' => $this->when($this->priority, $this->priority),
        'discount' => $this->when($this->discount, $this->discount),
        'criteria' => $this->when($this->criteria, $this->criteria),
        'dateStart' => $this->when($this->date_start, $this->date_start),
        'dateEnd' => $this->when($this->date_end, $this->date_end)
      ];

      return $data;

    }
}
