<?php

namespace Modules\Icommerce\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class ManufacturerTranslation extends Model
{
    use Sluggable;

    protected $table = 'icommerce__manufacturer_trans';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'translatable_options',
    ];

    protected $casts = [
        'translatable_options' => 'array',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }
}
