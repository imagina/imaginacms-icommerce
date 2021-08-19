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

    public function getProductAttribute(){
        return $this->products->first();
    }

    public function getProductableAttribute(){
        $classNamespace = get_class($this);
        $classNamespaceExploded = explode('\\',strtolower($classNamespace));
        $productableField = config('asgard.'.strtolower($classNamespaceExploded[1]).'.crud-fields.'.$classNamespaceExploded[3].'s.productable') ?? [];
        return $productableField['props']['multiple'] === true ? $this->products->pluck('id') : ($this->product->id ?? null);
    }

}
