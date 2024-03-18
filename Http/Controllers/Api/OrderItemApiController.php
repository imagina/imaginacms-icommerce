<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\OrderItem;
use Modules\Icommerce\Repositories\OrderItemRepository;

class OrderItemApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(OrderItem $model, OrderItemRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
