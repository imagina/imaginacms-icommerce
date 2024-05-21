<?php

namespace Modules\Icommerce\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Icommerce\Transformers\ProductOptionTransformer;
use Modules\Icommerce\Transformers\ProductOptionValueTransformer;

class ProductOptionPivotTransformer extends CrudResource
{
  /**
   * Method to merge values with response
   *
   * @return array
   */
  public function modelAttributes($request)
  {
    return [
      'id' => $this->when($this->pivot->id, $this->pivot->id),
      'type' => $this->when($this->type, $this->type),
      'description' => $this->when($this->description, $this->description),
      'productId' => $this->when($this->pivot->product_id, $this->pivot->product_id),
      'optionId' => $this->when($this->pivot->option_id, $this->pivot->option_id),
      'parentId' => $this->pivot->parent_id,
      'parentOptionValueId' => $this->when($this->pivot->parent_option_value_id, $this->pivot->parent_option_value_id),
      'value' => $this->when($this->pivot->value, $this->pivot->value),
      'required' => $this->when($this->pivot->required, (int)$this->pivot->required ? true : false),
      'option' => new ProductOptionTransformer($this->whenLoaded('option')),
      'productOptionValues' => ProductOptionValueTransformer::collection($this->whenLoaded('productOptionValues')),
    ];
  }
}
