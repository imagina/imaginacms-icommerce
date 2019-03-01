<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use Translatable;

    protected $table = 'icommerce__stores';

    public $translatedAttributes = [];

    protected $fillable = [
        'name',
        'address',
        'phone'
        // More data ...
    ];

    protected $fakeColumns = ['options'];

    protected $casts = [
        'options' => 'array'
    ];

    public function mapareas()
    {
        return $this->hasMany(MapArea::class);
    }

}
