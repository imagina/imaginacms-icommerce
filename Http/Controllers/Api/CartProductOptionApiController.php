<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\CartProductOption;
use Modules\Icommerce\Repositories\CartProductOptionRepository;

class CartProductOptionApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(CartProductOption $model, CartProductOptionRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
