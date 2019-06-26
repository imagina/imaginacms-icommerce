<?php

namespace Modules\Icommerce\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Icommerce\Transformers\ProductOptionValueTransformer;

class ProductOptionTransformer extends Resource
{
  public function toArray($request)
  {
    //Transformer only data base
    $data = [
      'id' => $this->when($this->id, $this->id),
      'type' => $this->whenLoaded('option', $this->option->type),
      'description' => $this->whenLoaded('option', $this->option->description),
      'productId' => $this->when($this->product_id, $this->product_id),
      'optionId' => $this->when($this->option_id, $this->option_id),
      'parentId' => $this->parent_id,
      'parentOptionValueId' => $this->when($this->parent_option_value_id, $this->parent_option_value_id),
      'value' => $this->when($this->value, $this->value),
      'required' => $this->when($this->required, (int)$this->required ? true : false),
      'productOptionValues' => ProductOptionValueTransformer::collection($this->whenLoaded('productOptionValues'))
    ];

    return $data;
  }
}
