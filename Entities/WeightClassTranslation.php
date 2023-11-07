<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class WeightClassTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      "title",
      "unit"
    ];
    protected $table = 'icommerce__weight_class_translations';
}
