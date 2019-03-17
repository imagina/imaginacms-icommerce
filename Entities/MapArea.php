<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class MapArea extends Model
{

    protected $table = 'icommerce__mapareas';

    protected $fillable = [
        'polygon',
        'store_id',
        'price',
        'minimum',
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
