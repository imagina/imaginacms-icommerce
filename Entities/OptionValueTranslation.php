<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class OptionValueTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['description'];
    protected $table = 'icommerce__option_value_trans';
}
