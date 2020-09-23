<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
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
      return $this->belongsToMany(TaxRate::class,'icommerce__tax_class_rate')->withPivot('tax_rate_id', 'based', 'priority')->withTimestamps();
    }
  
}
