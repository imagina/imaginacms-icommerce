<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class CurrencyTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
    protected $table = 'icommerce__currency_translations';
}
