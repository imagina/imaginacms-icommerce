<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\OrderStatusHistory;
use Modules\Icommerce\Repositories\OrderStatusHistoryRepository;

class OrderStatusHistoryApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(OrderStatusHistory $model, OrderStatusHistoryRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
