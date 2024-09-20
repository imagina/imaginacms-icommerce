<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Support\Traits\AuditTrait;

class TaxClass extends CrudModel
{
  use Translatable;

  protected $table = 'icommerce__tax_classes';
  public $transformer = 'Modules\Icommerce\Transformers\TaxClassTransformer';
  public $repository = 'Modules\Icommerce\Repositories\TaxClassRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateTaxClassRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateTaxClassRequest',
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
    'name',
    'description'
  ];
  protected $fillable = [];

  public function rates()
  {
    return $this->hasMany(TaxClassRate::class,'tax_class_id','id');
  }
}
