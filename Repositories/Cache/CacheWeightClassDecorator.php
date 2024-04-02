<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\WeightClassRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheWeightClassDecorator extends BaseCacheCrudDecorator implements WeightClassRepository
{
    public function __construct(WeightClassRepository $weightclass)
    {
        parent::__construct();
        $this->entityName = 'icommerce.weightclasses';
        $this->repository = $weightclass;
    }
}
