<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{

    protected $table = 'icommerce__wishlists';

    protected $fillable = [
        'user_id',
        'product_id',
        'store_id',
        'options'
    ];

    protected $casts = [
        'options' => 'array'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    public function store()
    {
        if (is_module_enabled('Marketplace')) {
            return $this->belongsTo('Modules\Marketplace\Entities\Store');
        }
        return $this->belongsTo(Store::class);
    }
}
