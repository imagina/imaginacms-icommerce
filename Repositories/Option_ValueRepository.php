<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface Option_ValueRepository extends BaseRepository
{
    /**
     * @param  number $id
     * @return mixed
     */
    public function findById($id);	
    
    /**
     * @param  number $id
     * @return mixed
     */
    public function findByParentId($id);	
}
