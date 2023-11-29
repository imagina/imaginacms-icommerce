<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Productable extends CrudModel
{


  protected $table = 'icommerce__productable';
  public $transformer = 'Modules\Icommerce\Transformers\ProductableTransformer';
  public $repository = 'Modules\Icommerce\Repositories\ProductableRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateProductableRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateProductableRequest',
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
    'productable_type',
    'productable_id',
    'product_id',
  ];

  public function product()
  {
    return $this->belongsTo(Product::class);
  }
}
