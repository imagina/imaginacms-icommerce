<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\TaxRate;
use Modules\Icommerce\Repositories\TaxRateRepository;

class TaxRateApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(TaxRate $model, TaxRateRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
