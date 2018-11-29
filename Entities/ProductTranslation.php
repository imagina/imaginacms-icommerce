<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'name',
      'description',
      'summary',
      'slug',
    ];
    protected $table = 'icommerce__product_translations';
}
