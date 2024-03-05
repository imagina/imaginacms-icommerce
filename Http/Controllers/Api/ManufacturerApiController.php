<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\Manufacturer;
use Modules\Icommerce\Repositories\ManufacturerRepository;

class ManufacturerApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Manufacturer $model, ManufacturerRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
