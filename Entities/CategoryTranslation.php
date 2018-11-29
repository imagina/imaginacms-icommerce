<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'title',
      'slug',
      'description',
      'meta_title',
      'meta_description'
    ];
    protected $table = 'icommerce__category_translations';
}
