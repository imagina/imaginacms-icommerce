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

    protected function setSlugAttribute($value)
    {
      
      if (!empty($value)) {
        $this->attributes['slug'] = str_slug($value, '-');
      } else {
        $this->attributes['slug'] = str_slug($this->title, '-');
      }
      
    }

}
