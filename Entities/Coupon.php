<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Bcrud\Support\Traits\CrudTrait;
use Modules\Bcrud\Support\ModelTraits\SpatieTranslatable\HasTranslations;

class Coupon extends Model
{
   
    use HasTranslations;
    use CrudTrait;

    protected $table = 'icommerce__coupons';

    public $translatable = ['name'];

    protected $fillable = ['name','code','type','discount','logged','shipping','total','datestart','dateend','uses_total','status'];


    public function products(){
    	return $this->belongsToMany(Product::class,'icommerce__coupon_product')->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'icommerce__coupon_category')->withTimestamps();
    }

    public function orders(){
        return $this->belongsToMany(Order::class, 'icommerce__coupon_history')->withPivot('amount')->withTimestamps();
    }

}
