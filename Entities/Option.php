<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Modules\Core\Support\Traits\AuditTrait;

class Option extends Model
{
    use Translatable, BelongsToTenant, AuditTrait;

    protected $table = 'icommerce__options';
    public $translatedAttributes = [
        'description'
    ];
    protected $fillable = [
        'type',
        'sort_order',
        'options'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function products(){
        return $this->belongsToMany(Product::class, 'icommerce__product_option')->withPivot('value', 'required')->withTimestamps();
    }

    public function optionValues(){
        return $this->hasMany(OptionValue::class);
    }

}
