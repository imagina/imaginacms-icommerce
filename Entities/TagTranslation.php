<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'title',
      'slug'
    ];
    protected $table = 'icommerce__tag_translations';
}
