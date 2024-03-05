<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\TaxClassRate;
use Modules\Icommerce\Repositories\TaxClassRateRepository;

class TaxClassRateApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(TaxClassRate $model, TaxClassRateRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
