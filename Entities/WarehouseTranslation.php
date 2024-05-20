<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class WarehouseTranslation extends Model
{

    use Sluggable;
    
    public $timestamps = false;
    protected $fillable = [
        'title',
        'slug',
        'description',
    ];
    protected $table = 'icommerce__warehouse_translations';

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
