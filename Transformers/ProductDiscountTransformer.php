<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Iprofile\Transformers\DepartmentTransformer;


class ProductDiscountTransformer extends Resource
  {
  public function toArray($request)
    {
      $data = [
        'id' => $this->when($this->id, $this->id),
        'productId' => $this->when($this->product_id, $this->product_id),
        'productOptionId' => $this->when($this->product_option_id, $this->product_option_id),
        'productOptionValueId' => $this->when($this->product_option_value_id, $this->product_option_value_id),
        'price' => $this->when(isset($this->price), $this->price),
        'quantity' => $this->when($this->quantity, $this->quantity),
        'priority' => $this->when($this->priority, $this->priority),
        'discount' => $this->when($this->discount, $this->discount),
        'criteria' => $this->when($this->criteria, $this->criteria),
        'departmentId' => $this->when($this->department_id, $this->department_id),
        'department' => new DepartmentTransformer($this->whenLoaded('department')),
        'dateStart' => $this->when($this->date_start, $this->date_start),
        'dateEnd' => $this->when($this->date_end, $this->date_end),
        'createdAt' => $this->when($this->created_at, $this->created_at),
        'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      ];

      return $data;

    }
}
