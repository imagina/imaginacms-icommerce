<?php

namespace Modules\Icommerce\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class CategoryTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
    return [
      'parentId' => (int)$this->parent_id,
      'sortOrder' => !$this->sort_order ? "0" : (string)$this->sort_order,
      'status' => $this->status ? '1' : '0',
    ];
  }
}
