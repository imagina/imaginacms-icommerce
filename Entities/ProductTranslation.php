<?php

namespace Modules\Icommerce\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
  use Sluggable;

  public $timestamps = false;
  protected $fillable = [
    'name',
    'description',
    'summary',
    'slug',
    'meta_title',
    'meta_description',
    'advanced_summary'
  ];
  protected $table = 'icommerce__product_translations';

  /**
   * Return the sluggable configuration array for this model.
   */
  public function sluggable(): array
  {
    return [
      'slug' => [
        'source' => 'name',
      ],
    ];
  }
}