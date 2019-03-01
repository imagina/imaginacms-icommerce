<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class MapArea extends Model
{
    use Translatable;

    protected $table = 'icommerce__mapareas';

    public $translatedAttributes = [

    ];
    protected $fillable = [
        'polygon',
        'store_id',
    ];

    protected $fakeColumns = ['options'];

    protected $casts = [
        'options' => 'array'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}
