<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\Productable;
use Modules\Icommerce\Repositories\ProductableRepository;

class ProductableApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Productable $model, ProductableRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
