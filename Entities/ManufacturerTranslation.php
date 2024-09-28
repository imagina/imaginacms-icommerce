<?php

namespace Modules\Icommerce\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class ManufacturerTranslation extends Model
{
  use Sluggable;

  public $timestamps = false;
  protected $fillable = [
    'name',
    'slug',
    'description',
    'meta_title',
    'meta_description',
    'translatable_options'
  ];
  protected $table = 'icommerce__manufacturer_trans';
  protected $casts = [
    'translatable_options' => 'array'
  ];

  public function sluggable(): array
  {
    return [
      'slug' => [
        'source' => 'name',
      ],
    ];
  }
}