<?php

namespace Modules\Icommerce\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Icurrency\Support\Facades\Currency;

class CartProductTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
    return [
      'total' => $this->when($this->total, Currency::convert($this->total)),
    ];
  }
}
