<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ShippingMethodRepository extends BaseRepository
{

  public function getItemsBy($params);
  
  public function getItem($criteria, $params);

  public function getCalculations($request, $params);

}
