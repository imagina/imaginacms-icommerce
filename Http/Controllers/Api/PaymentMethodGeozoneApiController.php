<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\PaymentMethodGeozone;
use Modules\Icommerce\Repositories\PaymentMethodGeozoneRepository;

class PaymentMethodGeozoneApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(PaymentMethodGeozone $model, PaymentMethodGeozoneRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
