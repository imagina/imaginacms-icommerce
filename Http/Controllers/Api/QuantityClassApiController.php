<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\QuantityClass;
use Modules\Icommerce\Repositories\QuantityClassRepository;

class QuantityClassApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(QuantityClass $model, QuantityClassRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
