<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\ProductOptionValue;
use Modules\Icommerce\Repositories\ProductOptionValueRepository;

class ProductOptionValueApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(ProductOptionValue $model, ProductOptionValueRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
