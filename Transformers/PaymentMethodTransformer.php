<?php

namespace Modules\Icommerce\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class PaymentMethodTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
    $calculations = isset($this->calculations) ? $this->calculations : null;
    return [
      "calculations" => $calculations
    ];
  }
}
