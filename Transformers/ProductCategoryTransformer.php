<?php

namespace Modules\Icommerce\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class ProductCategoryTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
    return [];
  }
}
