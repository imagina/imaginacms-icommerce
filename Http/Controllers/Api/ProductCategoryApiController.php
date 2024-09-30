<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\ProductCategory;
use Modules\Icommerce\Repositories\ProductCategoryRepository;

class ProductCategoryApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(ProductCategory $model, ProductCategoryRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
