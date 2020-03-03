<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CategoryRepository extends BaseRepository
{
  public function getItemsBy($params);

  public function getItem($criteria, $params);

}
