<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\AddressRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentAddressRepository extends EloquentBaseRepository implements AddressRepository
{
  public function findByUserId($id){
    return $this->model->where('user_id',$id)->get();
  }
}
