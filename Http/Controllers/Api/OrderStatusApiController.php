<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\OrderStatus;
use Modules\Icommerce\Repositories\OrderStatusRepository;

class OrderStatusApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(OrderStatus $model, OrderStatusRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
