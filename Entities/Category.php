<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Bcrud\Support\Traits\CrudTrait;

/*
use Modules\Bcrud\Support\ModelTraits\SpatieTranslatable\Sluggable;
use Modules\Bcrud\Support\ModelTraits\SpatieTranslatable\SluggableScopeHelpers;
*/
use Modules\Bcrud\Support\ModelTraits\SpatieTranslatable\HasTranslations;

class Category extends Model
{
    use CrudTrait;
    //use Sluggable, SluggableScopeHelpers;
    use HasTranslations;
   

    protected $table = 'icommerce__categories';

    //public $translatable = ['title','description','slug'];
    public $translatable = ['title','description'];
    protected $fillable = [
      'title',
      'slug',
      'description',
      'parent_id',
      'options'
    ];

    protected $fakeColumns = ['options'];

    protected $casts = [
        'options' => 'array'
    ];


    public function parent()
    {
        return $this->belongsTo('Modules\Icommerce\Entities\Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Modules\Icommerce\Entities\Category', 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany('Modules\Icommerce\Entities\Product','icommerce__product_category')->withTimestamps();
    }

    public function coupons()
    {
        return $this->belongsToMany('Modules\Icommerce\Entities\Coupon','icommerce__coupon_category')->withTimestamps();
    }

    protected function setSlugAttribute($value){

        if($this->parent_id==0){
            if(!empty($value)){
                $this->attributes['slug'] = str_slug($value,'-');
            }else{
                $this->attributes['slug'] = str_slug($this->title,'-');
            }
        }else{
            $this->attributes['slug'] = $this->parent->slug.'/'.str_slug($this->title,'-');
        }


    }

    public function getUrlAttribute() {

        return url(\LaravelLocalization::getCurrentLocale() . '/'.$this->slug);

    }
    public function getOptionsAttribute($value) {
        return json_decode(json_decode($value));
    }

    
}
