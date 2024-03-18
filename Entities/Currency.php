<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Support\Traits\AuditTrait;

class Currency extends CrudModel
{
  use Translatable;

  protected $table = 'icommerce__currencies';
  public $transformer = 'Modules\Icommerce\Transformers\CurrencyTransformer';
  public $repository = 'Modules\Icommerce\Repositories\CurrencyRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateCurrencyRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateCurrencyRequest',
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
  public $translatedAttributes = [
    'name'
  ];
  protected $fillable = [
    'code',
    'symbol_left',
    'symbol_right',
    'decimals',
    'decimal_separator',
    'thousands_separator',
    'store_id',
    'value',
    'status',
    'default_currency',
    'language',
    'options'
  ];


  protected $casts = [
    'options' => 'array'
  ];

  public function orders()
  {
    return $this->hasMany(Order::class);
  }
}
