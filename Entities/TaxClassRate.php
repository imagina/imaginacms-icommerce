<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class TaxClassRate extends Model
{
    use Translatable;

    protected $table = 'icommerce__tax_class_rate';

    public $translatedAttributes = [];

    protected $fillable = [
      'tax_class_id',
      'tax_rate_id',
      'based',
      'priority'
    ];
    
}
