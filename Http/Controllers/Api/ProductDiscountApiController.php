<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\ProductDiscount;
use Modules\Icommerce\Repositories\ProductDiscountRepository;

class ProductDiscountApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(ProductDiscount $model, ProductDiscountRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
