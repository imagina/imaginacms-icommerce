<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\VolumeClass;
use Modules\Icommerce\Repositories\VolumeClassRepository;

class VolumeClassApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(VolumeClass $model, VolumeClassRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
