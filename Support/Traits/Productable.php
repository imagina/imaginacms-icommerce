<?php

namespace Modules\Icommerce\Support\Traits;

use Modules\Icommerce\Entities\Product;

/**
 * Trait Productable
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
            $model->syncProduct();
        });

        static::updatedWithBindings(function ($model) {
            $model->syncProduct();
        });
    }

    /**
     * Sync Product
     */
    public function syncProduct()
    {
        \Log::info('Icommerce: Trait Productable - Entity ID:'.$this->id);

        $data = [
            'name' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'summary' => $this->summary ?? substr($this->description, 0, 150),
            'price' => $this->price,
            'status' => $this->status ?? 1,
            'stock_status' => $this->stock_status ?? 1,
            'quantity' => $this->quantity ?? 999999,
            'entity_id' => $this->id,
            'entity_type' => get_class($this),
        ];

        \Log::info('Icommerce: Trait Productable - Data:'.json_encode($data));

        $product = app('Modules\\Icommerce\\Repositories\\ProductRepository')->where('entity_id', $this->id)->first();

        if ($product) {
            $product->update($data);
        } else {
            $product = app('Modules\\Icommerce\\Repositories\\ProductRepository')->create($data);
        }
    }

    /**
     * Make the Productable morph relation
     */
    public function products(): object
    {
        return $this->morphMany(Product::class, 'entity');
    }

    public function getProductAttribute()
    {
        return $this->products->first();
    }

    public function getProductableAttribute()
    {
        $classNamespace = get_class($this);
        $classNamespaceExploded = explode('\\', strtolower($classNamespace));
        $productableField = config('asgard.'.strtolower($classNamespaceExploded[1]).'.crud-fields.'.$classNamespaceExploded[3].'s.productable') ?? [];

        return $productableField['props']['multiple'] === true ? $this->products->pluck('id') : ($this->product->id ?? null);
    }
}
