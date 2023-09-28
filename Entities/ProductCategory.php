<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'icommerce__product_category';

    protected $fillable = [
        'product_id',
        'category_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function manufacturers()
    {
        return $this->hasManyThrough(Manufacturer::class, Product::class);
    }
}
