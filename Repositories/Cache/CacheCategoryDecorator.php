<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCategoryDecorator extends BaseCacheCrudDecorator implements CategoryRepository
{
  public function __construct(CategoryRepository $category)
  {
    parent::__construct();
    $this->entityName = 'icommerce.categories';
    $this->repository = $category;
  }

  /**
   * List or resources
   *
   * @return collection
   */
  public function getItemsByForTheTreeFilter($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->getItemsByForTheTreeFilter($params);
    });
  }

}
