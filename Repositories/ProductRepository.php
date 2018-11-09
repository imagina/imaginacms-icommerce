<?php

namespace Modules\Icommerce\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface ProductRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    public function all();

    /**
     * @param  number $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param string $name
     * @return mixed
     */
    public function findByName($name,$filter,$type);


    /**
     * @param string $id
     * @return mixed
     */

    public function whereCategory($id);

    /**
     * param int $id
     * @return mixed
     */
    public function whereFeaturedProducts($id);


    /**
     * @param string $id
     * @return mixed
     */
    public function whereParentId($id);


    /**
     * @param string $slug
     * @param null $include
     * @return mixed
     */
    public function findBySlug($slug, $include=null);

    public function whereCategoryFilter($id,$filter,$type);

    /**
     * @return mixed
     */
    public function whereFreeshippingProducts();

    public function whereFreeshippingProductsFilter($filter);

    /**
     * @param $page
     * @param $take
     * @param object $filter
     * @param $include
     * @return mixed
     */
    public function whereFilters($page, $take, $filter, $include);
}
