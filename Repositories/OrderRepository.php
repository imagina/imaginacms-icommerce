<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface OrderRepository extends BaseRepository
{
  public function index($params);
  
  public function show($criteria, $params);
}
