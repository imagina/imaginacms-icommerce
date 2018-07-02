<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Bcrud\Support\Traits\CrudTrait;
use Modules\Bcrud\Support\ModelTraits\SpatieTranslatable\HasTranslations;

class Currency extends Model
{
	use HasTranslations;
    use CrudTrait;

    protected $table = 'icommerce__currencies';
    public $translatable = ['title'];

    protected $fillable = ['title','code','symbol_left','symbol_right','decimal_place','value','status'];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }


}
