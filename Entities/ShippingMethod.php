<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Media\Support\Traits\MediaRelation;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class ShippingMethod extends CrudModel
{
  use Translatable, MediaRelation, BelongsToTenant;

  protected $table = 'icommerce__shipping_methods';
  public $transformer = 'Modules\Icommerce\Transformers\ShippingMethodTransformer';
  public $repository = 'Modules\Icommerce\Repositories\ShippingMethodRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateShippingMethodRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateShippingMethodRequest',
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
    'title',
    'description'
  ];
  protected $fillable = [
    'status',
    'name',
    'options',
    'store_id',
    'geozone_id',
    'parent_name'
  ];
  protected $casts = [
    'options' => 'array'
  ];

  public $tenantWithCentralData = false;

  public function __construct(array $attributes = [])
  {
    try {
      $entitiesWithCentralData = json_decode(setting("icommerce::tenantWithCentralData", null, "[]"));
      $this->tenantWithCentralData = in_array("shippingMethods", $entitiesWithCentralData);
    } catch (\Exception $e) {
    }
    parent::__construct($attributes);
  }

  public function getOptionsAttribute($value)
  {

    return json_decode($value);

  }

  public function setOptionsAttribute($value)
  {

    $this->attributes['options'] = json_encode($value);

  }

  public function geozones()
  {
    return $this->belongsToMany('Modules\Ilocations\Entities\Geozones', 'icommerce__shipping_methods_geozones', 'shipping_method_id', 'geozone_id')->withTimestamps();
  }

}
