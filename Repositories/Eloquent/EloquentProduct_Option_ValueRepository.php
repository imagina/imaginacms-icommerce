<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\Product_Option_ValueRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentProduct_Option_ValueRepository extends EloquentBaseRepository implements Product_Option_ValueRepository
{
    /**
     * Find an option value by its parent option id
     * @param $id
     * @return mixed
     */
    public function findByOptionValueId($id)
    {
    	return $this->model->where('option_value_id', '=' , $id)->get();
    }
}
