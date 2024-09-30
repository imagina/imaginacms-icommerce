<?php

namespace Modules\Icommerce\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class CouponTransformer extends CrudResource
{
  /**
  * Method to merge values with response
  *
  * @return array
  */
  public function modelAttributes($request)
  {
    return [
      'type' => $this->type ? '1' : '0',
      'running' => $this->running,
      'finished' => $this->running ? false : true,
    ];
  }
}
