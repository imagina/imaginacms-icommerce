<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Icrud\Repositories\BaseCrudRepository;

interface CategoryRepository extends BaseCrudRepository
{

  public function getItemsByForTheTreeFilter($params);

}
