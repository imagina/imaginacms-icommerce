<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\ProductOptionValueWarehouse;
use Modules\Icommerce\Repositories\ProductOptionValueWarehouseRepository;

class ProductOptionValueWarehouseApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(ProductOptionValueWarehouse $model, ProductOptionValueWarehouseRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
