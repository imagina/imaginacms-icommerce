<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CategoryRepository extends BaseRepository
{
  public function findBySlug($slug);
  public function findParentCategories();
  public function allcat();
  public function all();
}
