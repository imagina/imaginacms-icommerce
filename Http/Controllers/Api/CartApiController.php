<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\Cart;
use Modules\Icommerce\Repositories\CartRepository;

class CartApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Cart $model, CartRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }

  public function create(Request $request)
  {

    $data["ip"] = $request->ip();
    $data["session_id"] = session('key');

    return parent::create(
      new Request([
        'attributes' => $data
      ])
    );
  }
}
