<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\Warehouse;
use Modules\Icommerce\Repositories\WarehouseRepository;

class WarehouseApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Warehouse $model, WarehouseRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
