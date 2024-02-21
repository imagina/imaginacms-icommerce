<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Modules\Core\Support\Traits\AuditTrait;

class ProductOptionValue extends Model
{
  use BelongsToTenant, AuditTrait, NodeTrait;
  protected $table = 'icommerce__product_option_value';

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
    'stock_status'
  ];

  // OK YA PROBADAS
  public function cartproductoptions()
  {
    return $this->hasMany(CartProductOption::class);
  }

  //************* OJO DUDAS PROBAR ********************
  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  //************* OJO DUDAS PROBAR ********************
  public function productOption()
  {
    return $this->belongsTo(ProductOption::class);
  }
  
  
  public function parentProductOptionValue()
  {
    return $this->belongsTo(ProductOptionValue::class,'parent_prod_opt_val_id');
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
      $warehouse = session('warehouse');
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
}
