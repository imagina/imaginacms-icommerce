<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class VolumeClass extends CrudModel
{
  use Translatable;

  protected $table = 'icommerce__volume_classes';
  public $transformer = 'Modules\Icommerce\Transformers\VolumeClassTransformer';
  public $repository = 'Modules\Icommerce\Repositories\VolumeClassRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateVolumeClassRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateVolumeClassRequest',
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
