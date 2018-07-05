<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface AddressRepository extends BaseRepository
{
  public function findByUserId($id);
}
