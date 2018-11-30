<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Bcrud\Support\Traits\CrudTrait;
use Modules\Bcrud\Support\ModelTraits\SpatieTranslatable\HasTranslations;

class Option extends Model
{
    use CrudTrait;
    use HasTranslations;

    protected $table = 'icommerce__options';

    public $translatable = ['description'];
    protected $fillable = ['type','description','sort_order','parent_id'];

    public function products(){
    	return $this->belongsToMany(Product::class, 'icommerce__product_option')->withPivot('value', 'required')->withTimestamps()->using(Product_Option::class);
    }

    public function option_values(){
    	return $this->hasMany(Option_Value::class);
    }

    //************* OJO DUDAS PROBAR ********************
    public function product_option_values(){
    	return $this->hasMany(Product_Option_Value::class);
    }

    //Relatión children options

    public function parent()
    {
        return $this->belongsTo('Modules\Icommerce\Entities\Option', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Modules\Icommerce\Entities\Option', 'parent_id');
    }

}
