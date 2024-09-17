<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\PaymentMethod;
use Modules\Icommerce\Repositories\PaymentMethodRepository;

class PaymentMethodApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(PaymentMethod $model, PaymentMethodRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
