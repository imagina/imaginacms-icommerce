<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\Currency;
use Modules\Icommerce\Repositories\CurrencyRepository;

class CurrencyApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Currency $model, CurrencyRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
