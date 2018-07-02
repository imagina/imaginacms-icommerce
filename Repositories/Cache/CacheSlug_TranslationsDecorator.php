<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\Slug_TranslationsRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSlug_TranslationsDecorator extends BaseCacheDecorator implements Slug_TranslationsRepository
{
    public function __construct(Slug_TranslationsRepository $slug_translations)
    {
        parent::__construct();
        $this->entityName = 'icommerce.slug_translations';
        $this->repository = $slug_translations;
    }
}
