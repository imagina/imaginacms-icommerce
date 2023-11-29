<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class LengthClass extends CrudModel
{
  use Translatable;

  protected $table = 'icommerce__length_classes';
  public $transformer = 'Modules\Icommerce\Transformers\LengthClassTransformer';
  public $repository = 'Modules\Icommerce\Repositories\LengthClassRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateLengthClassRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateLengthClassRequest',
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
