<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Icommerce\Presenters\CartPresenter;

class Cart extends Model
{
    use PresentableTrait;
    protected $table = 'icommerce__carts';

    protected $fillable = [
        'user_id',
        'ip',
        'session_id',
        'options',
        'status',
        'store_id',
    ];

    protected $presenter = CartPresenter::class;
    protected $casts = [
        'options' => 'array'
    ];

    public function user()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    public function products()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function getTotalAttribute()
    {
        return $this->products->sum('total');
    }

    public function getQuantityAttribute()
    {
        return $this->products->count();
    }

}
