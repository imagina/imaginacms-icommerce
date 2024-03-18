<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\ItemType;
use Modules\Icommerce\Repositories\ItemTypeRepository;

class ItemTypeApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(ItemType $model, ItemTypeRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
