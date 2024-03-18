<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class TaxRate extends CrudModel
{
  use Translatable;

  protected $table = 'icommerce__tax_rates';
  public $transformer = 'Modules\Icommerce\Transformers\TaxRateTransformer';
  public $repository = 'Modules\Icommerce\Repositories\TaxRateRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateTaxRateRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateTaxRateRequest',
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
    'name'
  ];
  protected $fillable = [
    'rate',
    'type',
    'geozone_id',
    'customer',
    'tax_class_id',
    'store_id'
  ];

    public function geozone()
    {
        return $this->belongsTo('Modules\Ilocations\Entities\Geozones', 'geozone_id');
    }

    public function taxClass()
    {
        return $this->belongsTo(TaxClass::class, 'tax_class_id');
    }

    public function calcTax($value)
    {
        if ($this->type == 2) {
            return $this->rate;
        }

        if ($this->type == 1) {
            return floatval(($value * $this->rate) / 100);
        }
    }
}
