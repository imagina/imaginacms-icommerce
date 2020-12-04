<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class CurrencyTranslation extends Model
{
    /**
     * @var $table string
     */
    protected $table = 'icommerce__currency_translations';
    /**
     * @var  $timestamps bool
     */
    public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

}
