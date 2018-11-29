<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class ManufacturerTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'name'
    ];
    protected $table = 'icommerce__manufacturer_translations';
}
