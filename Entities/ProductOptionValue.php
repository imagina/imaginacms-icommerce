<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Core\Support\Traits\AuditTrait;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class ProductOptionValue extends CrudModel
{
  use BelongsToTenant, NodeTrait;

  protected $table = 'icommerce__product_option_value';
  public $transformer = 'Modules\Icommerce\Transformers\ProductOptionValueTransformer';
  public $repository = 'Modules\Icommerce\Repositories\ProductOptionValueRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateProductOptionValueRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateProductOptionValueRequest',
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
    'product_option_id',
    'product_id',
    'option_id',
    'option_value_id',
    'parent_option_value_id',
    'parent_prod_opt_val_id',
    'quantity',
    'subtract',
    'price',
    'price_prefix',
    'points',
    'points_prefix',
    'weight',
    'weight_prefix',
    'stock_status',
    'options'
  ];

  protected $casts = [
    'options' => 'array'
  ];

  public function cartproductoptions()
  {
    return $this->hasMany(CartProductOption::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function productOption()
  {
    return $this->belongsTo(ProductOption::class);
  }

  public function parentProductOptionValue()
  {
    return $this->belongsTo(ProductOptionValue::class, 'parent_prod_opt_val_id');
  }

  //************* OJO DUDAS PROBAR ********************
  public function option()
  {
    return $this->belongsTo(Option::class);
  }

  //************* OJO DUDAS PROBAR ********************
  public function optionValue()
  {
    return $this->belongsTo(OptionValue::class);
  }

  public function parentOptionValue()
  {
    return $this->belongsTo(OptionValue::class, 'parent_option_value_id');
  }

  public function orderOption()
  {
    return $this->hasMany(OrderOption::class);
  }

  public function getAvailableAttribute()
  {
    $warehouseEnabled = setting('icommerce::warehouseFunctionality', null, false);
    if ($warehouseEnabled && $this->subtract) {
      $warehouse = request()->session()->get('warehouse');
      $warehouse = json_decode($warehouse);
      if (isset($warehouse->id)) {
        $warehouse = app('Modules\Icommerce\Repositories\WarehouseRepository')->getItem($warehouse->id);
      }

      if (!is_null($warehouse)) {
        $warehouseProductQuantity = \DB::table('icommerce__product_option_value_warehouse')
          ->where('warehouse_id', $warehouse->id)
          ->where('product_option_value_id', $this->id)
          ->where('product_id', $this->product_id)
          ->first();
        if (isset($warehouseProductQuantity) && $warehouseProductQuantity->quantity == 0 || is_null($warehouseProductQuantity)) {
          $this->quantity = 0;
        } else {
          $this->quantity = $warehouseProductQuantity->quantity;
        }
      }
    }
    return $this->stock_status && (($this->subtract && $this->quantity) || !$this->subtract);
  }

  public function childrenProductOptionValue()
  {
    return $this->hasMany($this, 'parent_prod_opt_val_id', 'id');
  }

  public function updateStockByChildren()
  {
    $stock = 0;
    if ($this->subtract) {
      foreach ($this->childrenProductOptionValue as $key => $children) {
        if ($children->subtract && $children->stock_status == 1) {
          $stock += $children->quantity;
        }
      }
      $this->update(["quantity" => $stock]);
      if ($stock == 0) {
        $this->update(["stock_status" => 0]);
      } elseif ($this->stock_status == 0 && $this->childrenProductOptionValue()->where("stock_status", 1)->get()->isNotEmpty()) {
        $this->update(["stock_status" => 1]);
      }
      if ($this->parentProductOptionValue) {
        $this->parentProductOptionValue->updateStockByChildren();
      }
      return $stock;

    }
    return $this->quantity;
  }

  public function getLftName()
  {
    return 'lft';
  }

  public function getRgtName()
  {
    return 'rgt';
  }

  public function getDepthName()
  {
    return 'depth';
  }

  public function getParentIdName()
  {
    return 'parent_prod_opt_val_id';
  }

  public function getFullNameAttribute()
  {
    $ancestorsAndSelf = ProductOptionValue::with(["option","option.translations","optionValue","optionValue.translations","children"])->ancestorsAndSelf($this->id);
    $fullname = "";

    foreach ($ancestorsAndSelf as $productOptionValue)
      $fullname .= ($productOptionValue->option ? $productOptionValue->option->description : "") . ": " .
        ($productOptionValue->optionValue ? $productOptionValue->optionValue->description : "") . ($productOptionValue->children->isNotEmpty() ? " / " : "");


    return $fullname;
  }

  public function getCacheClearableData()
  {
    return [
      'urls' => [
        $this->product->url
      ]
    ];
}

//Importante: getOptionsAttribute funcionaba bien en el proceso web, pero en los JOBS fallaba
//Por lo tanto si se extrae, se manipula como array los Options
//public function getOptionsAttribute($value){ return json_decode($value);

/**
 * SETTER
 */
public function setOptionsAttribute($value)
{
  $this->attributes['options'] = json_encode($value);
}

}
