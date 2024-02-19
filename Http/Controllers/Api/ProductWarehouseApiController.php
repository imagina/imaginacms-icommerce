<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\ProductWarehouse;
use Modules\Icommerce\Repositories\ProductWarehouseRepository;

class ProductWarehouseApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(ProductWarehouse $model, ProductWarehouseRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
