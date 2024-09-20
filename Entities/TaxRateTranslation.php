<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class TaxRateTranslation extends Model
{
  public $timestamps = false;
  protected $fillable = ['name'];
  protected $table = 'icommerce__tax_rate_translations';
}