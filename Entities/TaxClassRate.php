<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class TaxClassRate extends Model
{

    protected $table = 'icommerce__tax_class_rate';
    
    protected $fillable = [
      'tax_class_id',
      'tax_rate_id',
      'based',
      'priority'
    ];
    
}
