<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use Translatable;

    protected $table = 'icommerce__addresses';
    public $translatedAttributes = [];
    protected $fillable = [
      'user_id',
      'firstname',
      'lastname',
      'company',
      'address_1',
      'address_2',
      'city',
      'postcode',
      'country',
      'zone'
    ];
    
}
