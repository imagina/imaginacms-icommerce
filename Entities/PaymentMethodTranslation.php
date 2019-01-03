<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodTranslation extends Model
{
  
  public $timestamps = false;
  
    protected $fillable = [
      'title',
      'description'
    ];
    protected $table = 'icommerce__payment_method_translations';
}
