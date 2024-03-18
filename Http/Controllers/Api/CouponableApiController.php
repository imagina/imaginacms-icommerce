<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\Couponable;
use Modules\Icommerce\Repositories\CouponableRepository;

class CouponableApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Couponable $model, CouponableRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
