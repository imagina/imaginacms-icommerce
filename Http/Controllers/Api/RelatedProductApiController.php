<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\RelatedProduct;
use Modules\Icommerce\Repositories\RelatedProductRepository;

class RelatedProductApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(RelatedProduct $model, RelatedProductRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
