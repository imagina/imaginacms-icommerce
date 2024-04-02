<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\WeightClass;
use Modules\Icommerce\Repositories\WeightClassRepository;

class WeightClassApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(WeightClass $model, WeightClassRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
