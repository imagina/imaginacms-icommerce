<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Media\Entities\File;
use Modules\Core\Traits\NamespacedEntity;

class OptionValue extends Model
{
  use Translatable, NamespacedEntity, MediaRelation;

  protected $table = 'icommerce__option_values';
  public $translatedAttributes = [
    'description'
  ];
  protected $fillable = [
    'option_id',
    'sort_order',
    'options'
  ];


  protected $casts = [
    'options' => 'array'
  ];

  public function option()
  {
    return $this->belongsTo(Option::class);
  }

  public function getOptionsAttribute($value)
  {
    try {
      $response = json_decode(json_decode($value));
    } catch (\Exception $e) {
      $response = json_decode($value);
    }

    return $response ? $response : (object)[];
  }

  public function optionValues()
  {
    return $this->belongsToMany(Product::class, 'icommerce__product_option_value')
      ->withPivot(
        'id', 'product_option_id', 'option_id',
        'parent_option_value_id', 'quantity',
        'subtract', 'price', 'weight'
      )->withTimestamps();
  }

  public function productOptionValues()
  {
    return $this->belongsToMany(Product::class, 'icommerce__product_option_value')
      ->withPivot(
        'id', 'product_option_id', 'option_id',
        'parent_option_value_id', 'quantity',
        'subtract', 'price', 'weight'
      )->withTimestamps();
  }

  public function getMainImageAttribute()
  {
    $thumbnail = $this->files()->where('zone', 'mainimage')->first();
    if (!$thumbnail) return [
      'mimeType' => 'image/jpeg',
      'path' => url('modules/iblog/img/post/default.jpg')
    ];
    return [
      'mimeType' => $thumbnail->mimetype,
      'path' => $thumbnail->path_string
    ];
  }
}
