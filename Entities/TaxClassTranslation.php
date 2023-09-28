<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class TaxClassTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $table = 'icommerce__tax_class_translations';
}
