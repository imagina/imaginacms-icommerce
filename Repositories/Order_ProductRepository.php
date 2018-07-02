<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface Order_ProductRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    public function whereFeaturedProducts();
}
