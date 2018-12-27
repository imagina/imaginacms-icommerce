<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface TaxClassRepository extends BaseRepository
{
  public function index($params);
  
  public function show($criteria, $params);
  
  public function create($data);
  
  public function updateBy($criteria, $data, $params);
  
  public function deleteBy($criteria, $params);
}
