<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\CouponRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Entities\Status;

class EloquentCouponRepository extends EloquentBaseRepository implements CouponRepository
{

	public function findByCode($code)
    {
    	return $this->model->where('code', $code)
    	->whereDate('date_start','<=',date("Y-m-d"))
    	->whereDate('date_end','>=',date("Y-m-d"))
    	->whereStatus(Status::ENABLED)
    	->where("uses_total",">",0)
    	->first();
    }

}