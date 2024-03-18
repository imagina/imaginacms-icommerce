<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class TaxClassRate extends CrudModel
{
  use Translatable;

  protected $table = 'icommerce__tax_class_rate';
  public $transformer = 'Modules\Icommerce\Transformers\TaxClassRateTransformer';
  public $repository = 'Modules\Icommerce\Repositories\TaxClassRateRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateTaxClassRateRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateTaxClassRateRequest',
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
    'tax_class_id',
    'tax_rate_id',
    'based',
    'priority'
  ];

    public function taxRate()
    {
        return $this->belongsTo(TaxRate::class);
    }

    public function taxClass()
    {
        return $this->belongsTo(TaxClass::class);
    }
}
