<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Bcrud\Support\Traits\CrudTrait;
use Modules\Bcrud\Support\ModelTraits\SpatieTranslatable\HasTranslations;

class Option_Value extends Model
{
    
    use CrudTrait;
    use HasTranslations;

    protected $table = 'icommerce__option_values';
    public $translatable = ['description'];
    
    protected $fillable = ['option_id','image','description','sort_order'];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
    
    //************* OJO DUDAS PROBAR ********************
    public function product_option_values(){
    	return $this->hasMany(Product_Option_Value::class, 'icommerce__product_option_values')->withTimestamps();
    }

}
