<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\Subscription;
use Modules\Icommerce\Repositories\SubscriptionRepository;

class SubscriptionApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Subscription $model, SubscriptionRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
