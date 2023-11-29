<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Modules\Core\Support\Traits\AuditTrait;

class ProductOption extends Model
{
  use NodeTrait, BelongsToTenant, AuditTrait;
  
  protected $table = 'icommerce__product_option';
  
  protected $with = ["productOptionValues"];
  
  protected $fillable = [
    'product_id',
    'option_id',
    'parent_id',
    'parent_option_value_id',
    'value',
    'required',
    'sort_order'
  ];
  
  public function option()
  {
    return $this->belongsTo(Option::class);
  }
  
  public function parent()
  {
    return $this->belongsTo(Option::class, 'parent_id');
  }
  
  public function product()
  {
    return $this->belongsTo(Product::class);
  }
  
  public function productOptionValues()
  {
    return $this->hasMany(ProductOptionValue::class);
  }
  
  public function orderOptions()
  {
    return $this->hasMany(OrderOption::class);
  }

  public function parentOptionValue()
  {
    return $this->belongsTo(OptionValue::class, 'parent_option_value_id');
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
    return 'parent_id';
  }
}
