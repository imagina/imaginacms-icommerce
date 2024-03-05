<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\Transaction;
use Modules\Icommerce\Repositories\TransactionRepository;

class TransactionApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Transaction $model, TransactionRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
