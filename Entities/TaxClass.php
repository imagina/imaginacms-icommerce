<?php

namespace Modules\Icommerce\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class TaxClass extends Model
{
    // use Translatable;

    protected $table = 'icommerce__taxclasses';
    // public $translatedAttributes = [];
    protected $fillable = [];
}
