<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

  protected $table = 'icommerce__order_item';

  protected $fillable = [
    'order_id',
    'product_id',
    'item_type_id',
    'title',
    'reference',
    'quantity',
    'price',
    'total',
    'tax',
    'reward',
    'options',
    'entity_type',
    'entity_id',
    'discount'
  ];


  protected $casts = [
    'options' => 'array',
    'discount' => 'array',
  ];

  public function entity(){
     return $this->belongsTo($this->entity_type,'entity_id');
  }

  public function orderOption(){
    return $this->hasMany(OrderOption::class);
  }

  public function type(){
    return $this->belongsTo(ItemType::class);
  }

  public function order(){
    return $this->belongsTo(Order::class,'order_id');
  }

  public function product(){
    return $this->belongsTo(Product::class,'product_id');
  }

  public function getOptionsAttribute($value)
  {

    return json_decode($value);

  }

  public function setOptionsAttribute($value)
  {

    $this->attributes['options'] = json_encode($value);

  }

  public function getDiscountAttribute($value)
  {

    return json_decode($value);

  }

  public function setDiscountAttribute($value)
  {

    $this->attributes['discount'] = json_encode($value);

  }

}
