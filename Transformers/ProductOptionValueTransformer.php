<?php

namespace Modules\Icommerce\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class ProductOptionValueTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
    return [
      'parentId' => $this->parent_prod_opt_val_id ?? 0,
      'optionValue' => $this->when($this->option_value_id,$this->optionValue->description),
      'parentOptionValue' => $this->whenLoaded('parentOptionValue',$this->parentOptionValue ? $this->parentOptionValue->description : '-')
    ];
  }
}
