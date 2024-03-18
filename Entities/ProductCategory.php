<?php

namespace Modules\Icommerce\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

class ProductCategory extends CrudModel
{

  protected $table = 'icommerce__product_category';
  public $transformer = 'Modules\Icommerce\Transformers\ProductCategoryTransformer';
  public $repository = 'Modules\Icommerce\Repositories\ProductCategoryRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateProductCategoryRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateProductCategoryRequest',
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
    'product_id',
    'category_id'
  ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function manufacturers()
    {
        return $this->hasManyThrough(Manufacturer::class, Product::class);
    }
}
