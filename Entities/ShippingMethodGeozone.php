<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ShippingMethodGeozone extends Pivot
{

  protected $table = 'icommerce__shipping_methods_geozones';
  public $transformer = 'Modules\Icommerce\Transformers\ShippingMethodGeozoneTransformer';
  public $repository = 'Modules\Icommerce\Repositories\ShippingMethodGeozoneRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateShippingMethodGeozoneRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateShippingMethodGeozoneRequest',
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

    protected $fillable = [
        'id',
        'shipping_method_id',
        'geozone_id',
    ];
}
