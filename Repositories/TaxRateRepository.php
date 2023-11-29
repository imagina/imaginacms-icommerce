<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface TaxRateRepository extends BaseRepository
{
  public function getItemsBy($params);
  
  public function getItem($criteria, $params = false);

}
