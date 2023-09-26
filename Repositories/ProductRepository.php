<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ProductRepository extends BaseRepository
{
    public function getItemsBy($params);

    public function getItem($criteria, $params = false);

    public function updateBy($criteria, $data, $params = false);

    public function deleteBy($criteria, $params = false);

    public function getPriceRange($params);

    public function getManufacturers($params);

    public function getProductOptions($params);
}
