<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\OrderOption;
use Modules\Icommerce\Repositories\OrderOptionRepository;

class OrderOptionApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(OrderOption $model, OrderOptionRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
