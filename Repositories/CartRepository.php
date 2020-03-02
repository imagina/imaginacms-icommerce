<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CartRepository extends BaseRepository
{
  public function getItemsBy($params);

  public function getItem($criteria, $params);


}
