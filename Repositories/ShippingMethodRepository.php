<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Icrud\Repositories\BaseCrudRepository;

interface ShippingMethodRepository extends BaseCrudRepository
{
  
  public function getCalculations($request, $params);
}
