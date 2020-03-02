<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use Translatable;

    protected $table = 'icommerce__item_types';
    public $translatedAttributes = [
        'title'
    ];
    protected $fillable = [
        'options'
    ];


    protected $casts = [
        'options' => 'array'
    ];
}
