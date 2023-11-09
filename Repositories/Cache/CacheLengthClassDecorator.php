<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\LengthClassRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheLengthClassDecorator extends BaseCacheCrudDecorator implements LengthClassRepository
{
    public function __construct(LengthClassRepository $lengthclass)
    {
        parent::__construct();
        $this->entityName = 'icommerce.lengthclasses';
        $this->repository = $lengthclass;
    }
}
