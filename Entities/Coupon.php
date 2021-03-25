<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Coupon extends Model
{

  protected $table = 'icommerce__coupons';

  protected $fillable = [
    'code',
    'type',
    'category_id',
    'product_id',
    'customer_id',
    'store_id',
    'discount',
    'type_discount',
    'logged',
    'shipping',
    'date_start',
    'date_end',
    'quantity_total',
    'quantity_total_customer',
    'status',
    'options',
    'minimum_order_amount',
    'minimum_quantity_products',
    'exclude_departments',
    'include_departments'
  ];

  private $auth;

  protected $casts = [
    'options' => 'array',
    'exclude_departments' => 'array',
    'include_departments' => 'array'
  ];


  public function __construct(array $attributes = [])
  {
    $this->auth = Auth::user();
    parent::__construct($attributes);
  }

  public function store()
  {
    if (is_module_enabled('Marketplace')) {
      return $this->belongsTo('Modules\Marketplace\Entities\Store');
    }
    return $this->belongsTo(Store::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function customer()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'customer_id');
  }

  public function orders()
  {
    return $this->belongsToMany(Order::class, 'icommerce__coupon_order_history')->withTimestamps()->withPivot('amount');
  }


  public function couponHistories()
  {
    return $this->hasMany(CouponOrderHistory::class);
  }


  /*
  * Mutators / Accessors
  */
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

  /*
  * Polimorphy Relations
  */
  public function products()
  {
    return $this->morphedByMany(Product::class, 'couponable', 'icommerce__couponables');
  }

  public function categories()
  {
    return $this->morphedByMany(Category::class, 'couponable', 'icommerce__couponables');
  }

  public function manufacturers()
  {
    return $this->morphedByMany(Manufacturer::class, 'couponable', 'icommerce__couponables');
  }

  /*
  * Attributes
  */
  public function getUsesTotalAttribute()
  {
    return $this->has('orders')->count();
  }

  public function getUsesTotalPerUserAttribute()
  {
    return $this->whereHas('orders', function ($query) {
      $query->where('icommerce__coupon_order_history.customer_id', Auth::id());
    })->count();
  }

  public function getRunningAttribute()
  {

    // Validate if coupon active (0 is ID for inactive coupons)
    if ($this->status == 0) {
      return false;
    }

    // validate if the coupon is valid (Dates)
    $now = date('Y-m-d');
    if (!($now >= $this->date_start)) {
      return false;
    }
    if (!($now <= $this->date_end)) {
      return false;
    }

    // Validate the number of times the coupon has been used
    if ($this->quantity_total > 0) {//If quantity total == 0 is infinite
      if ($this->usesTotal >= $this->quantity_total) {
        return false;
      }
    }

    return true;
  }

  public function getCanUseAttribute()
  {

    $user = $this->auth;
    $userId = $user->id ?? 0;
    //dd($userId);
    $departments = [];
    if (!empty($userId)) {
      $departments = \DB::table('iprofile__user_department')
        ->where("user_id", $userId)
        ->get()
        ->pluck("department_id")->toArray();
    }

    $excludeDepartments = $this->exclude_departments;
    $includeDepartments = $this->include_departments;

    //validate exclude departments
    if(!empty($excludeDepartments)){
      foreach ($departments as $departmentId){
        if(in_array($departmentId,$excludeDepartments)){ // si alguno de los departamentos del usuario está en los excluidos: return false
          return false;
        }
      }
    }

    //validate include departments
    if(!empty($includeDepartments) && !empty(array_diff($includeDepartments, ["0"]))){ // si hay departamentos incluidos y no está 0 = ALL
      $departmentsIntersection = array_intersect($departments,$includeDepartments);
      if(empty($departmentsIntersection)){
        return false;
      }
    }

    // Validate the number of times the coupon has been used by the logged in user
    if ($this->quantity_total_customer > 0 && $this->logged && Auth::id() != null) { //If quantity total == 0 is infinite
      if ($this->usesTotalPerUser >= $this->quantity_total_customer) {
        return false;
      }
    }



    return true;
  }

}
