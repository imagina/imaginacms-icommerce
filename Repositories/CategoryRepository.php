<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface CategoryRepository extends BaseRepository
{
    public function all();
    /**
     * @param $slug
     * @return mixed
     */

    public function findBySlug($slug);

    /**
     * @return mixed
     */
    public function findParentCategories();

    /**
     * @return mixed
     */
    public function allcat();

    /**
     * @param object $filter
     * @return mixed
     */
    public function whereFilters($filter);
}
