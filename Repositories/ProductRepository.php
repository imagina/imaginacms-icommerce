<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Icrud\Repositories\BaseCrudRepository;

interface ProductRepository extends BaseCrudRepository
{

  public function getPriceRange($params);

  public function getManufacturers($params);

  public function getProductOptions($params);

}
