<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    use Translatable;

    protected $table = 'icommerce__price_lists';
    public $translatedAttributes = [
        'name'
    ];
    protected $fillable = [
        'status',
        'criteria',
        'related_id',
        'related_entity',
        'operation_prefix',
        'value',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'icommerce__product_lists')
            ->withPivot('id', 'price')
            ->withTimestamps()
            ->using(ProductList::class);
    }

    public function getEntityAttribute()
    {
        if($this->related_entity && $this->related_id)
            return app($this->related_entity)->find($this->related_id);
        else
            return null;
    }

}
