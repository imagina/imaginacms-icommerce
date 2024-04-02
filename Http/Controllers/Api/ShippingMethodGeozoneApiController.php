<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\ShippingMethodGeozone;
use Modules\Icommerce\Repositories\ShippingMethodGeozoneRepository;

class ShippingMethodGeozoneApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(ShippingMethodGeozone $model, ShippingMethodGeozoneRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
}
