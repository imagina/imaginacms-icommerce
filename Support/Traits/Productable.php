<?php


namespace Modules\Icommerce\Support\Traits;

use Modules\Icommerce\Entities\Product;

/**
 * Trait Productable
 * @package Modules\Icommerce\Support\Traits
 *
 */
trait Productable
{

    /**
     * Make the Productable morph relation
     * @return object
     */
    public function products()
    {
        return $this->morphToMany(Product::class, 'productable', 'icommerce__productable')
            ->withPivot('productable_type')
            ->withTimestamps();
    }

    public function product(){
        return $this->products()->first();
    }

}
