<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\TagRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTagDecorator extends BaseCacheDecorator implements TagRepository
{
    public function __construct(TagRepository $tag)
    {
        parent::__construct();
        $this->entityName = 'icommerce.tags';
        $this->repository = $tag;
    }
}
