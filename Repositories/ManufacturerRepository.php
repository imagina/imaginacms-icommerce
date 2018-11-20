<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ManufacturerRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    public function countAll();

    public function findByid($id);
}
