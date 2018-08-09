<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface TaxRatesRepository extends BaseRepository
{
  public function getAll();
}
