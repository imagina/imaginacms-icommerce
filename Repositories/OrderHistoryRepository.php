<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface OrderHistoryRepository extends BaseRepository
{
  public function getItemsBy($params);

  public function getItem($criteria, $params);

}
