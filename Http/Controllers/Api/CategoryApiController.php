<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Repositories\CategoryRepository;

class CategoryApiController extends BaseCrudController
    {
  public $model;
  public $modelRepository;

  public function __construct(Category $model, CategoryRepository $modelRepository)
    {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
    }
}
