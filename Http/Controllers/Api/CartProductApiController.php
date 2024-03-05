<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\CartProduct;
use Modules\Icommerce\Repositories\CartProductRepository;

class CartProductApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(CartProduct $model, CartProductRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
