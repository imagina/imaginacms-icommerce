<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iprofile\Transformers\DepartmentTransformer;

class ProductDiscountTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'productId' => $this->when($this->product_id, $this->product_id),
            'productOptionId' => $this->when($this->product_option_id, $this->product_option_id),
            'productOptionValueId' => $this->when($this->product_option_value_id, $this->product_option_value_id),
            'price' => $this->when(isset($this->price), $this->price),
            'finished' => $this->finished,
            'running' => $this->running,
            'quantity' => $this->when($this->quantity, $this->quantity),
            'quantitySold' => $this->when($this->quantity_sold, $this->quantity_sold),
            'priority' => $this->when($this->priority, $this->priority),
            'discount' => $this->when($this->discount, $this->discount),
            'criteria' => $this->when($this->criteria, $this->criteria),
            'departmentId' => $this->when($this->department_id, $this->department_id),
            'excludeDepartments' => $this->exclude_departments,
            'includeDepartments' => $this->include_departments,
            'department' => new DepartmentTransformer($this->whenLoaded('department')),
            'dateStart' => $this->when($this->date_start, $this->date_start),
            'dateEnd' => $this->when($this->date_end, $this->date_end),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
        ];

        return $data;
    }
}
