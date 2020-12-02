<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class ItemTypeTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'title'
    ];
    protected $table = 'icommerce__item_type_translations';
}
