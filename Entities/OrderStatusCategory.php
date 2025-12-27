<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class OrderStatusCategory extends CrudModel
{
  use Translatable;

  protected $table = 'icommerce__order_status_categories';
  public $transformer = 'Modules\Icommerce\Transformers\OrderStatusCategoryTransformer';
  public $repository = 'Modules\Icommerce\Repositories\OrderStatusCategoryRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateOrderStatusCategoryRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateOrderStatusCategoryRequest',
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
    'title'
  ];
  protected $fillable = [
    'type',
    'internal',
    'options',
  ];

  protected $casts = [
    'options' => 'array',
  ];
}
