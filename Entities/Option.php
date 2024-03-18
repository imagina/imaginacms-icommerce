<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Support\Traits\AuditTrait;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Option extends CrudModel
{
  use Translatable, BelongsToTenant;

  protected $table = 'icommerce__options';
  public $transformer = 'Modules\Icommerce\Transformers\OptionTransformer';
  public $repository = 'Modules\Icommerce\Repositories\OptionRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateOptionRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateOptionRequest',
    ];
  //Instance external/internal events to dispatch with extraData
  public $dispatchesEventsWithBindings = [
    //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
    'created' => [],
    'creating' => [],
    'updated' => [],
    'updating' => [],
    'deleting' => [],
    'deleted' => []
  ];
  public $translatedAttributes = [  'description'];
  protected $fillable = [
    'type',
    'sort_order',
    'options'
  ];

    protected $casts = [
        'options' => 'array',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'icommerce__product_option')->withPivot('value', 'required')->withTimestamps();
    }

  public function optionValues(){
    return $this->hasMany(OptionValue::class);
  }


  public function getDynamicAttribute()
  {
    $type = new OptionType();
    $typeData = $type->get($this->type);

    return $typeData['dynamic'];
  }

}
