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
    * Boot trait method
    */
    public static function bootProductable()
    {
        //Listen event after create model
        static::createdWithBindings(function ($model) {
          $model->createProduct();
        });

    }

    /**
    * Create a Product
    */
    public function createProduct(){

        // Data to Create
        $dataToCreate = [
            'name' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'summary' => $this->summary ?? substr($this->description, 0, 150),
            'price' => $this->price,
            'status' => 1,
            'stock_status' => 1,
            'quantity' => 999999,
            'entity_id' => $this->id,
            'entity_type' => get_class($this) 
        ];

        // Create Product
        $product = app('Modules\\Icommerce\\Repositories\\ProductRepository')->create($dataToCreate);
    }


    /**
     * Make the Productable morph relation
     * @return object
     */
    public function products()
    {
        return $this->morphMany(Product::class, 'entity');
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
