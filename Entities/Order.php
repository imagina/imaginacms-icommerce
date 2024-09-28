<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Ilocations\Entities\Country;
use Modules\Ilocations\Entities\Province;
use Modules\Isite\Entities\Organization;
use Modules\Isite\Traits\RevisionableTrait;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Order extends CrudModel
{
  use BelongsToTenant;

  protected $table = 'icommerce__orders';
  public $transformer = 'Modules\Icommerce\Transformers\OrderTransformer';
  public $repository = 'Modules\Icommerce\Repositories\OrderRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateOrderRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateOrderRequest',
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
    'parent_id',
    'cart_id',
    'invoice_nro',
    'invoice_prefix',
    'total',
    'status_id',
    'customer_id',
    'added_by_id',
    'first_name',
    'last_name',
    'email',
    'telephone',
    'payment_first_name',
    'payment_last_name',
    'payment_telephone',
    'payment_company',
    'payment_nit',
    'payment_email',
    'payment_address_1',
    'payment_address_2',
    'payment_city',
    'payment_zip_code',
    'payment_country',
    'payment_zone',
    'payment_address_format',
    'payment_custom_field',
    'payment_method',
    'payment_code',
    'payment_name',
    'shipping_first_name',
    'shipping_last_name',
    'shipping_telephone',
    'shipping_company',
    'shipping_address_1',
    'shipping_address_2',
    'shipping_city',
    'shipping_zip_code',
    'shipping_country_code',
    'shipping_zone',
    'shipping_address_format',
    'shipping_custom_field',
    'shipping_method',
    'shipping_code',
    'shipping_amount',
    'store_id',
    'store_name',
    'store_address',
    'store_phone',
    'tax_amount',
    'comment',
    'tracking',
    'currency_id',
    'currency_code',
    'currency_value',
    'ip',
    'user_agent',
    'key',
    'require_shipping',
    'options',
    'suscription_id',
    'organization_id',
    'suscription_token',
    'type',
    'guest_purchase',
    'warehouse_id',
    'warehouse_title',
    'warehouse_address'
  ];


  protected $casts = [
    'options' => 'array'
  ];

  protected $with = [
    'status'
  ];

  public function customer()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'customer_id');
  }

  public function addedBy()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'added_by_id');
  }

  public function products()
  {
    return $this->belongsToMany(Product::class, 'icommerce__order_item')
      ->withPivot(
        'title', 'reference', 'quantity',
        'price', 'total', 'tax', 'reward')
      ->withTimestamps()
      ->using(OrderItem::class);
  }

  public function orderItems()
  {
    return $this->hasMany(OrderItem::class);
  }

  public function parent()
  {
    return $this->belongsTo(Order::class, 'parent_id');
  }

  public function children()
  {
    return $this->hasMany(Order::class, 'parent_id');
  }

  public function coupons()
  {
    return $this->belongsToMany(Coupon::class, 'icommerce__coupon_order_history')
      ->withPivot('amount')
      ->withTimestamps();
  }

  public function orderHistory()
  {
    return $this->hasMany(OrderStatusHistory::class);
  }

  public function orderOption()
  {
    return $this->hasMany(OrderOption::class);
  }

  public function status()
  {
    return $this->belongsTo(OrderStatus::class, 'status_id');
  }

  public function getStatusNameAttribute()
  {
    return $this->status->title;
  }

  public function organization()
  {
    return $this->belongsTo(Organization::class);
  }

  public function currency()
  {
    return $this->belongsTo(Currency::class);
  }

  public function conversation()
  {
    return $this->hasOne("Modules\Ichat\Entities\Conversation", 'entity_id');
  }

  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }

  public function shippings()
  {
    return $this->hasMany(Shipping::class);
  }

  public function getOptionsAttribute($value)
  {
    return json_decode($value);
  }

  public function getUrlAttribute()
  {
    $panel = config('asgard.iprofile.config.panel') ?? 'blade';
    if ($panel == 'blade' || $this->guest_purchase) {
      return \URL::route(locale() . '.icommerce.store.order.show', ['orderId' => $this->id, 'orderKey' => $this->key]);
    } else {
      return \URL::to('/ipanel/#/store/orders/' . $this->id);
    }
  }

  public function getCouponTotalAttribute()
  {
    return $this->coupons->sum('pivot.amount');
  }

  public function setOptionsAttribute($value)
  {
    $this->attributes['options'] = json_encode($value);
  }

  public function paymentCountry()
  {
    return $this->belongsTo(Country::class, 'payment_country', 'iso_2')->with('translations');
  }

  public function shippingCountry()
  {
    return $this->belongsTo(Country::class, 'shipping_country_code', 'iso_2')->with('translations');
  }

  public function paymentDepartment()
  {
    return $this->belongsTo(Province::class, 'payment_zone', 'iso_2')->with('translations');
  }

  public function shippingDepartment()
  {
    return $this->belongsTo(Province::class, 'shipping_zone', 'iso_2')->with('translations');
  }

  public function warehouse()
  {
    return $this->belongsTo(Warehouse::class);
  }
}