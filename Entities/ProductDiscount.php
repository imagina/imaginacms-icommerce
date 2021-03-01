<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Iprofile\Entities\Department;

class ProductDiscount extends Model
{

  protected $table = 'icommerce__product_discounts';

  protected $fillable = [
    'product_id',
    'product_option_id',
    'product_option_value_id',
    'quantity',
    'quantity_sold',
    'priority',
    'discount',
    'criteria',
    'date_start',
    'date_end',
    'department_id',
    'exclude_departments',
    'include_departments',
  ];
  protected $casts = [
    'exclude_departments' => 'array',
    'include_departments' => 'array'
  ];

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function productOptionValue()
  {
    return $this->belongsTo(ProductOptionValue::class);
  }

  public function productOption()
  {
    return $this->belongsTo(ProductOption::class);
  }

  public function getFinishedAttribute()
  {
    $now = date('Y-m-d');

    $endDate = date('Y-m-d', strtotime($this->date_end));

    return $this->quantity_sold >= $this->quantity
      || ($now > $endDate);
  }

  public function getRunningAttribute()
  {
    $now = date('Y-m-d');
    $startDate = date('Y-m-d', strtotime($this->date_start));
    $endDate = date('Y-m-d', strtotime($this->date_end));

    return $this->quantity_sold < $this->quantity
      && (($now >= $startDate) && ($now <= $endDate));
  }

  public function getPriceAttribute()
  {

    $basePrice = $this->product->present()->price;
    $valueDiscount = $this->calcDiscount($basePrice);

    return floatval($basePrice) - floatval($valueDiscount);

  }

  public function getTotalDiscountAttribute()
  {

    $basePrice = $this->product->present()->price;
    $valueDiscount = $this->calcDiscount($basePrice);

    return $valueDiscount;

  }

  public function setExcludeDepartmentsAttribute($value)
  {
    $this->attributes['exclude_departments'] = json_encode($value);
  }

  public function getExcludeDepartmentsAttribute($value)
  {
    return json_decode($value);
  }

  public function setIncludeDepartmentsAttribute($value)
  {
    $this->attributes['include_departments'] = json_encode($value);
  }

  public function getIncludeDepartmentsAttribute($value)
  {
    return json_decode($value);
  }

  public function department()
  {
    return $this->belongsTo(Department::class);
  }

  private function calcDiscount($value)
  {
    if ($this->criteria == 'fixed') {
      return ($this->discount);
    }

    if ($this->criteria == 'percentage') {
      return floatval(($value * $this->discount) / 100);
    }
  }
}
