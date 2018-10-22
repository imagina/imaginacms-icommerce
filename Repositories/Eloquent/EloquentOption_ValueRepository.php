<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\Option_ValueRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentOption_ValueRepository extends EloquentBaseRepository implements Option_ValueRepository
{
    /**
     * Find an option value by its id
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
    	return $this->model->where('id', '=' , $id)->first();
    }

    /**
     * Find an option value by its parent option id
     * @param $id
     * @return mixed
     */
    public function findByParentId($id)
    {
    	return $this->model->where('option_id', '=' , $id)->get();
    }

    public function getValues($option_id){
      return $this->model->where('option_id',$option_id)->get();
    }//getValues
}
