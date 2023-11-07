<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class WeightClass extends CrudModel
{
  use Translatable;

  protected $table = 'icommerce__weight_classes';
  public $transformer = 'Modules\Icommerce\Transformers\WeightClassTransformer';
  public $repository = 'Modules\Icommerce\Repositories\WeightClassRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateWeightClassRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateWeightClassRequest',
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
  public $translatedAttributes = [];
  protected $fillable = [
    "value",
    "default"
  ];
}
