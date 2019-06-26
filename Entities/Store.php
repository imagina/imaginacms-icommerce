<?php

namespace Modules\Icommerce\Entities;


use Illuminate\Database\Eloquent\Model;

class Store extends Model
{


    protected $table = 'icommerce__stores';



    protected $fillable = [
        'name',
        'address',
        'phone',
        // More data ...
    ];

    protected $fakeColumns = ['options'];

    protected $casts = [
        'options' => 'array'
    ];

  

}
