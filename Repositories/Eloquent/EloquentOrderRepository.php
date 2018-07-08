<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentOrderRepository extends EloquentBaseRepository implements OrderRepository
{
  /**
   * @param $status
   * @return mixed
   */
  public function countStatus($status)
  {
    $this->model->where('order_status', $status)->count();
  }
  
  public function findByUser($id, $userId)
  {
    return $this->model->where('user_id', $userId)->where('id', $id)->first();
  }
  
  public function findByKey($id, $key)
  {
    return $this->model->where('key', $key)->where('id', $id)->first();
  }
  
  /**
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function whereUser($id)
  {
    return $this->model->where('user_id', $id)->paginate(12);
  }
  
}
