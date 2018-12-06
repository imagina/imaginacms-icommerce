<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CartProductRepository extends BaseRepository
{
  public function index($params);
  
  public function show($criteria, $params);
}
