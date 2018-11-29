<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class OptionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'description'
    ];
    protected $table = 'icommerce__option_translations';
}
