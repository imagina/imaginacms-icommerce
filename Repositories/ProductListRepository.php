<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ProductListRepository extends BaseRepository
{
  public function index($params);
  
  public function show($criteria, $params);
}
