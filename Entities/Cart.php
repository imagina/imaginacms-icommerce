<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Icrud\Entities\CrudModel;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Cart extends CrudModel
{
  use PresentableTrait, BelongsToTenant;

  protected $table = 'icommerce__carts';
  public $transformer = 'Modules\Icommerce\Transformers\CartTransformer';
  public $repository = 'Modules\Icommerce\Repositories\CartRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateCartRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateCartRequest',
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
    'user_id',
    'ip',
    'session_id',
    'options',
    'status',
    'store_id',
  ];

  public $tenantWithCentralData = false;

  protected $casts = [
    'options' => 'array'
  ];

  public function __construct(array $attributes = [])
  {
    try{
      $entitiesWithCentralData = json_decode(setting("icommerce::tenantWithCentralData",null,"[]"));
      $this->tenantWithCentralData = in_array("carts",$entitiesWithCentralData);
    }catch(\Exception $e){}
    parent::__construct($attributes);

  }

  public function user()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
  }

  public function products()
  {
    return $this->hasMany(CartProduct::class);
  }

  public function productsToCheckout()
  {
    return $this->hasMany(CartProduct::class)->whereHas("product", function ($query) {
      $query->where("icommerce__products.is_call", false);
    })->where("icommerce__cart_product.is_call", false);
  }

  public function getTotalAttribute()
  {
    return $this->products->sum('total');
  }

  public function getQuantityAttribute()
  {
    return $this->products->count();
  }

  public function getRequireShippingAttribute()
  {


    $requireShipping = false;

    if ($this->products->isNotEmpty()) {
      foreach ($this->products as $cartProduct) {
        if ($cartProduct->product->shipping) {
          $requireShipping = true;
        }
      }
    }
    return $requireShipping;

  }
}