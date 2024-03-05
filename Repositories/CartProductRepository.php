<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Icrud\Repositories\BaseCrudRepository;

interface CartProductRepository extends BaseCrudRepository
{
  public function productHasValidQuantity($cartProduct, $product = null, $productOptionsValues = null, $data = null, $productOptionValuesFrontend = null);
  
}
