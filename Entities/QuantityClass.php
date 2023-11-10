<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class QuantityClass extends CrudModel
{
  use Translatable;

  protected $table = 'icommerce__quantity_classes';
  public $transformer = 'Modules\Icommerce\Transformers\QuantityClassTransformer';
  public $repository = 'Modules\Icommerce\Repositories\QuantityClassRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateQuantityClassRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateQuantityClassRequest',
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
    "title",
    "unit"
  ];
  protected $fillable = [
    "value",
    "default"
  ];
}
