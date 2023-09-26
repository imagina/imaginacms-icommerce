<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class CurrencyTranslation extends Model
{
    /**
     * @var string
     */
    protected $table = 'icommerce__currency_translations';

    /**
     * @var  bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
