<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use Translatable;

  protected $table = 'icommerce__products';
  public $translatedAttributes = [
    'name',
    'description',
    'summary',
    'slug'
  ];
  protected $fillable = [
    'added_by_id',
    'options',
    'status',
    'user_id',
    'category_id',
    'parent_id',
    'tax_class_id',
    'sku',
    'quantity',
    'stock_status',
    'manufacturer_id',
    'shipping',
    'price',
    'points',
    'date_available',
    'weight',
    'length',
    'width',
    'height',
    'subtract',
    'minimum',
    'reference',
    'rating',
    'freeshipping',
    'order_weight'
  ];
  protected $fakeColumns = ['options'];

  protected $casts = [
    'options' => 'array'
  ];

  public function user()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo('Modules\\User\\Entities\\{$driver}\\User','added_by_id');
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function taxClass()
  {
    return $this->belongsTo(TaxClass::class);
  }

  public function categories()
  {
    return $this->belongsToMany(Category::class, 'icommerce__product_category')->withTimestamps();
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class, 'icommerce__product_tag')->withTimestamps();
  }

  public function orderItems()
  {
    return $this->hasMany(OrderItem::class);
  }

  //public function featuredProducts()
  //{
    //return $this->hasMany(OrderItem::class)->select('SUM(quantity) AS total_products')->groupBy('product_id');
  //}

  public function manufacturer()
  {
    return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
  }

  public function discounts()
  {
    return $this->hasMany(ProductDiscount::class);
  }

  public function productOptions()
  {
    return $this->belongsToMany(Option::class, 'icommerce__product_option')
      ->withPivot('id', 'value', 'required')
      ->withTimestamps()
      ->using(ProductOption::class);
  }

  /*public function optionValues()
  {
    return $this->belongsToMany(OptionValue::class, 'icommerce__option_values')
      ->withPivot(
        'id', 'product_option_id', 'option_id',
        'parent_option_value_id', 'quantity',
        'substract', 'price', 'weight'
      )->withTimestamps()
      ->using(ProductOptionValue::class);
  }*/

  public function relatedProducts()
  {
    return $this->belongsToMany('Modules\Icommerce\Entities\Product', 'icommerce__related_product')->withTimestamps();
  }

  public function orders()
  {
    return $this->belongsToMany(Order::class, 'icommerce__order_item')
      ->withPivot('title', 'reference', 'quantity', 'price', 'total', 'tax', 'reward')
      ->withTimestamps()
      ->using(OrderItem::class);
  }

  public function wishlists()
  {
    return $this->hasMany(Wishlist::class);
  }

  public function coupons()
  {
    return $this->belongsToMany(Coupon::class, 'icommerce__coupon_product')->withTimestamps();
  }

  public function parent()
  {
    return $this->belongsTo('Modules\Icommerce\Entities\Product', 'parent_id');
  }

  public function children()
  {
    return $this->hasMany('Modules\Icommerce\Entities\Product', 'parent_id')
      ->orderBy('order_weight', 'desc')
      ->orderBy('created_at', 'desc');
  }

  public function comments()
  {
    return $this->hasMany(Comment::class);
  }

  protected function setSlugAttribute($value)
  {

    if (!empty($value)) {
      $this->attributes['slug'] = istr_slug($value, '-');
    } else {
      $this->attributes['slug'] = str_slug($this->title, '-');
    }

  }

  protected function setSummaryAttribute($value)
  {

    if (!empty($value)) {
      $this->attributes['summary'] = $value;
    } else {
      $this->attributes['summary'] = substr(strip_tags($this->description), 0, 150);
    }

  }

  protected function setQuantityAttribute($value)
  {

    if (!empty($value)) {
      $this->attributes['quantity'] = $value;
    } else {
      $this->attributes['quantity'] = 0;
    }

  }

  protected function setPriceAttribute($value)
  {

    if (!empty($value)) {
      $this->attributes['price'] = $value;
    } else {
      $this->attributes['price'] = 0;
    }

  }

  protected function setMinimumAttribute($value)
  {

    if (!empty($value)) {
      $this->attributes['minimum'] = $value;
    } else {
      $this->attributes['minimum'] = 1;
    }

  }

  protected function setSkuAttribute($value)
  {

    if (!empty($value)) {
      $this->attributes['sku'] = $value;
    } else {
      $this->attributes['sku'] = uniqid("s");
    }

  }

  public function getOptionsAttribute($value)
  {
    if (!is_string(json_decode($value))) {
      return json_decode($value);
    }
    return json_decode(json_decode($value));
  }


  public function getUrlAttribute()
  {

    return \URL::route(\LaravelLocalization::getCurrentLocale() . '.icommerceslug.' . $this->slug);
  }

  protected function setRatingAttribute($value)
  {

    if (!empty($value)) {
      $this->attributes['rating'] = $value;
    } else {
      $this->attributes['rating'] = 3;
    }

  }

  /* product discount return if discount is active */
  public function getDiscountAttribute()
  {
    $date = date_create(date("Y/m/d"));

    $query = $this->product_discounts()
      ->select('price')
      ->whereDate('date_start', '<=', $date)
      ->whereDate('date_end', '>=', $date)
      ->first();

    return $query ? $query->price : null;
  }

  public function getGalleryAttribute()
  {
    $images = \Storage::disk('publicmedia')->files('assets/icommerce/product/gallery/' . $this->id);
    return $images;
  }

  /*
  public function getRelatedIdsAttribute($value)
  {

    if (!empty($value)) {
      $ids = json_decode($value);
      $productsRelated = Product::whereIn("id", $ids)->take(20)->get();
      return $productsRelated;
    }

  }*/
}
