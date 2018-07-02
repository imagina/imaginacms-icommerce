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
        $this->model->where('order_status',$status)->count();
    }

        public function find($id)
    {
        return $this->model->find($id);
    }

        public function findByUser($id,$user_id)
    {
        return $this->model->where('user_id', $user_id)->where('id', $id)->first();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->orderBy('created_at', 'DESC')->paginate(500);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function whereUser($id)
    {
        return $this->model->where('user_id', $id)->get();
    }

}
