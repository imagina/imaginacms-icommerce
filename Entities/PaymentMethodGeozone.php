<?php

namespace Modules\Icommerce\Entities;


use Modules\Core\Icrud\Entities\CrudModel;

class PaymentMethodGeozone extends CrudModel
{

  protected $table = 'icommerce__payment_methods_geozones';
  public $transformer = 'Modules\Icommerce\Transformers\PaymentMethodGeozoneTransformer';
  public $repository = 'Modules\Icommerce\Repositories\PaymentMethodGeozoneRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreatePaymentMethodGeozoneRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdatePaymentMethodGeozoneRequest',
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
        'payment_method_id',
        'geozone_id',
    ];
}
