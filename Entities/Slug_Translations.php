<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Slug_Translations extends Model
{
    use Translatable;

    protected $table = 'icommerce__slug_translations';
    public $translatedAttributes = [];
    protected $fillable = [];
}
