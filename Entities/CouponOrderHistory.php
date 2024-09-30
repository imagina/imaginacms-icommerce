<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class CouponOrderHistory extends CrudModel
{
  protected $table = 'icommerce__coupon_order_history';
  public $transformer = 'Modules\Icommerce\Transformers\CouponOrderHistoryTransformer';
  public $repository = 'Modules\Icommerce\Repositories\CouponOrderHistoryRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateCouponOrderHistoryRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateCouponOrderHistoryRequest',
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
    'coupon_id',
    'order_id',
    'customer_id',
    'amount'
  ];
  
  
  public function coupon()
  {
    return $this->belongsTo(Coupon::class);
  }
  
  public function order()
  {
    return $this->belongsTo(Order::class);
  }
  
  public function customer()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'customer_id');
  }
}
