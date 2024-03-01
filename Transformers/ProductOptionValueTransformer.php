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
    ];
  }
}
