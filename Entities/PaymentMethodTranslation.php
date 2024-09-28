<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodTranslation extends Model
{
  public $timestamps = false;
  protected $fillable = [
    'title',
    'description',
    'payment_method_id',
    'locale',
  ];
  protected $table = 'icommerce__payment_method_translations';
}