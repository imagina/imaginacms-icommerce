<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Icrud\Repositories\BaseCrudRepository;

interface PaymentMethodRepository extends BaseCrudRepository
{
  public function getCalculations($params);
}
