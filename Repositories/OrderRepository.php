<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface OrderRepository extends BaseRepository
{
  /**
   * @param $status
   * @return mixed
   */
  public function countStatus($status);
  
  public function whereUser($id);
  
  public function all();
  
  public function findByUser($id, $userId);
  
  public function findByKey($id, $key);
}
