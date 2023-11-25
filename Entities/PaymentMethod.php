<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Icrud\Traits\hasEventsWithBindings;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Iforms\Support\Traits\Formeable;
use Modules\Media\Support\Traits\MediaRelation;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class PaymentMethod extends CrudModel
{
  use Translatable, MediaRelation, Formeable, BelongsToTenant;

  protected $table = 'icommerce__payment_methods';
  public $transformer = 'Modules\Icommerce\Transformers\PaymentMethodTransformer';
  public $repository = 'Modules\Icommerce\Repositories\PaymentMethodRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreatePaymentMethodRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdatePaymentMethodRequest',
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
    'payout',
    'geozone_id',
    'parent_name'
  ];

  protected $casts = [
    'options' => 'array'
  ];

  public function getOptionsAttribute($value)
  {
    return json_decode($value);
  }


  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }

  public function geozones()
  {
    return $this->belongsToMany('Modules\Ilocations\Entities\Geozones', 'icommerce__payment_methods_geozones', 'payment_method_id', 'geozone_id')->withTimestamps();
  }

}
