<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class LengthClassTranslation extends Model
{
  public $timestamps = false;
  protected $fillable = [
    "title",
    "unit"
  ];
    protected $table = 'icommerce__length_class_translations';
}
