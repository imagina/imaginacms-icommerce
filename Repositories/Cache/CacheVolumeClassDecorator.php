<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\VolumeClassRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheVolumeClassDecorator extends BaseCacheCrudDecorator implements VolumeClassRepository
{
    public function __construct(VolumeClassRepository $volumeclass)
    {
        parent::__construct();
        $this->entityName = 'icommerce.volumeclasses';
        $this->repository = $volumeclass;
    }
}
