<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class PriceListTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'name'
    ];
    protected $table = 'icommerce__price_list_translations';
}
