<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icommerce\Entities\Status;

class EloquentManufacturerRepository extends EloquentBaseRepository implements ManufacturerRepository
{

    public function countAll()
    {
        return $this->model->count();
    }

    public function withFile()
    {
        return $this->model->whereStatus(Status::ENABLED)->orderBy('created_at', 'DESC')->paginate(12);
    }
    
    public function findByid($id){
        return $this->model->find($id);
    }
    
}
