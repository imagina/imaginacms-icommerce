<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data =  [
      'id' => $this->id,
      'code' => $this->when($this->code, $this->code),
      'type' => $this->type ? '1' : '0',
      'running' => $this->running,
      'finished' => $this->running ? false : true,
      'categoryId' => $this->when($this->category_id, $this->category_id),
      'productId' => $this->when($this->product_id, $this->product_id),
      'customerId' => $this->when($this->customer_id, $this->customer_id),
      'discount' => $this->when($this->discount, $this->discount),
      'typeDiscount' => $this->type_discount,
      'logged' => $this->logged,
      'shipping' => $this->shipping,
      'dateStart' => $this->when($this->date_start, $this->date_start),
      'dateEnd' => $this->when($this->date_end, $this->date_end),
      'quantityTotal' => $this->when($this->quantity_total, $this->quantity_total),
      'quantityTotalCustomer' => $this->when($this->quantity_total_customer, $this->quantity_total_customer),
      'status' => $this->status,
      'product' => $this->when($this->product_id, new ProductTransformer($this->whenLoaded('product'))),
      //'category' => $this->when($this->category_id, new CategoryTransformer($this->whenLoaded('category'))),
      'categories' => CategoryTransformer::collection($this->whenLoaded('categories')),
      'products' => ProductTransformer::collection($this->whenLoaded('products')),
      'manufacturers' => ManufacturerTransformer::collection($this->whenLoaded('manufacturers')),
      'minimumOrderAmount' => (float)$this->minimum_order_amount,
      'minimumQuantityProducts' => (int)$this->minimum_quantity_products,
      'excludeDepartments' => $this->exclude_departments,
      'includeDepartments' => $this->include_departments,
    ];

    return $data;
  }
}
