<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\TaxRatesRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentTaxRatesRepository extends EloquentBaseRepository implements TaxRatesRepository
{
  public function getAll(){
    return $this->model->with(['geozone'])->get();
  }
}
