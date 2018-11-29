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
}
