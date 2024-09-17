<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class VolumeClassTranslation extends Model
{
  public $timestamps = false;
  protected $fillable = [
    "title",
    "unit"
  ];
  protected $table = 'icommerce__volume_class_translations';
}
