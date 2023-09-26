<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductableEntity extends Model
{
    protected $table = 'icommerce__productable';

    protected static $entityNamespace = 'asgardcms/productableEntity';

    protected $fillable = [
        'productable_type',
        'productable_id',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
