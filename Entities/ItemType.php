<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class ItemType extends CrudModel
{
  use Translatable;

  protected $table = 'icommerce__item_types';
  public $transformer = 'Modules\Icommerce\Transformers\ItemTypeTransformer';
  public $repository = 'Modules\Icommerce\Repositories\ItemTypeRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateItemTypeRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateItemTypeRequest',
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
  public $translatedAttributes = [ 'title'];
  protected $fillable = [ 'options'];
  protected $casts = [
    'options' => 'array'
  ];
}