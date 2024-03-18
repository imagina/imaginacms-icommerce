<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\CouponOrderHistory;
use Modules\Icommerce\Repositories\CouponOrderHistoryRepository;

class CouponOrderHistoryApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(CouponOrderHistory $model, CouponOrderHistoryRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
