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
     * @return mixed
     */
    public function findBySlug($slug);

    public function whereCategoryFilter($id,$filter,$type);

    /**
     * @return mixed
     */
    public function whereFreeshippingProducts();

    public function whereFreeshippingProductsFilter($filter);
}
