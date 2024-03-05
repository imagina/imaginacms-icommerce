<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\TaxClass;
use Modules\Icommerce\Repositories\TaxClassRepository;

class TaxClassApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(TaxClass $model, TaxClassRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
