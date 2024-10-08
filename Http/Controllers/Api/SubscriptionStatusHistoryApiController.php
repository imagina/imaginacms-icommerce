<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\SubscriptionStatusHistory;
use Modules\Icommerce\Repositories\SubscriptionStatusHistoryRepository;

class SubscriptionStatusHistoryApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(SubscriptionStatusHistory $model, SubscriptionStatusHistoryRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
