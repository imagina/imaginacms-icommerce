<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface OptionRepository extends BaseRepository
{
  /**
  * @param object $filter
  * @return mixed
  */
  public function whereFilters($filter);
}
