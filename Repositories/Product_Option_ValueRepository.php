<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface Product_Option_ValueRepository extends BaseRepository
{
    /**
     * @param  number $id
     * @return mixed
     */
    public function findByOptionValueId($id);
}
