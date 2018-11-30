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

  /**
   * @return mixed
   */
  public function findParentOptions();
  public function getChildrenOptions();
}
