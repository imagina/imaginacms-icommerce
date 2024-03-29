<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class TaxClass extends Model
{
    use Translatable;

    protected $table = 'icommerce__tax_classes';
    public $translatedAttributes = [
      'name',
      'description'
    ];
    protected $fillable = [];

    public function rates()
    {
      return $this->hasMany(TaxClassRate::class,'tax_class_id','id');
    }

}
