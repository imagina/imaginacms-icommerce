<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\LengthClass;
use Modules\Icommerce\Repositories\LengthClassRepository;

class LengthClassApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(LengthClass $model, LengthClassRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
