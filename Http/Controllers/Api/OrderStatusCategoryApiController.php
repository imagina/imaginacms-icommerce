<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\OrderStatusCategory;
use Modules\Icommerce\Repositories\OrderStatusCategoryRepository;

class OrderStatusCategoryApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(OrderStatusCategory $model, OrderStatusCategoryRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
