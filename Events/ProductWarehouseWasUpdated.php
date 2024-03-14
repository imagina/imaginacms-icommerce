<?php

namespace Modules\Icommerce\Events;

use Modules\User\Entities\Sentinel\User;

class ProductWarehouseWasUpdated
{

  public $entity;

  public function __construct($productOptionValue)
  {
    $this->entity = $productOptionValue;
  }

}