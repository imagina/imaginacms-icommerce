<?php

namespace Modules\Icommerce\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

use Modules\Notification\Traits\IsNotificable;

class Subscription extends CrudModel
{

  use IsNotificable;

  protected $table = 'icommerce__subscriptions';
  public $transformer = 'Modules\Icommerce\Transformers\SubscriptionTransformer';
  public $repository = 'Modules\Icommerce\Repositories\SubscriptionRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateSubscriptionRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateSubscriptionRequest',
    ];
  //Instance external/internal events to dispatch with extraData
  public $dispatchesEventsWithBindings = [
    //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
    'created' => [
      ['path' => "Modules\\Icommerce\\Events\\SubscriptionWasCreated"]
    ],
    'creating' => [],
    'updated' => [
      ['path' => "Modules\\Icommerce\\Events\\SubscriptionWasUpdated"]
    ],
    'updating' => [],
    'deleting' => [],
    'deleted' => []
  ];
  
  protected $fillable = [
    'order_id',
    'order_item_id',
    'product_id',
    'customer_id',
    'order_option_id',
    'option_description',
    'option_value_description',
    'payment_method',
    'payment_code',
    'currency_id',
    'currency_code',
    'currency_value',
    'price',
    'frequency',
    'due_date',
    'days_before_due',
    'days_for_suspension',
    'status_id',
    'options'
  ];

  protected $casts = [
    'options' => 'array'
  ];

  /*
  * ======================= RELATIONS
  */

  public function order()
  {
    return $this->belongsTo(Order::class, 'order_id');
  }

  public function orderItem()
  {
    return $this->belongsTo(OrderItem::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }

  public function customer()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'customer_id');
  }

  
  public function currency()
  {
    return $this->belongsTo(Currency::class);
  }

  public function orders()
  {
    return $this->belongsToMany(Order::class, 'icommerce__order_subscription')->withTimestamps();
  }

  public function subscriptionStatusHistory()
  {
    return $this->hasMany(SubscriptionStatusHistory::class);
  }

  /*
  * ======================= ACCESORS
  */
  public function getStatusLabelAttribute()
  {
    return (new SubscriptionStatus())->get($this->status_id);
  }

  public function getOptionsAttribute($value)
  {
    return json_decode($value);
  }

  /*
  * ======================= MUTATORS
  */
  public function setOptionsAttribute($value)
  {
    $this->attributes['options'] = json_encode($value);
  }

  /**
   * Make Notificable Params | to Trait
   * @param $event (created|updated|deleted)
   */
  public function isNotificableParams($event)
  {

    $response = [];

    //Get Emails and Broadcast
    $result =  app("Modules\Icommerce\Services\SubscriptionService")->getEmailsAndBroadcast($this);

    //Base Source | Iadmin filter
    $userId = \Auth::id() ?? null;
    $source = "iadmin";
    
    // EVENT CREATED
    if($event=="created"){
  
      //Message
      $message = trans("icommerce::subscriptions.messages.subscription created", [
        'title' => $this->orderItem->title,
        'frequency'=> $this->option_value_description,
        'status' => $this->statusLabel,
        'dueDate' => date('d-m-Y', strtotime($this->due_date)),
        'paymentMethod' => $this->payment_method
      ]);

      //Data Created
      $response['created'] = [
        "title" => trans("icommerce::subscriptions.title.subscription created",['id' => $this->id]),
        "message" => $message,
        "email" => $result['email'],
        "broadcast" => $result['broadcast'],
        "userId" => $userId,
        "source" => $source
      ];

    }

    // EVENT UPDATE | Status
    if ($event == "updated") {

      //Validation Att Status Change
      if (!$this->wasChanged("status_id")) {
        return null;
      }

      //Message
      $message = trans("icommerce::subscriptions.messages.subscription updated", [
        'title' => $this->orderItem->title,
        'frequency'=> $this->option_value_description,
        'status' => $this->statusLabel,
        'dueDate' => date('d-m-Y', strtotime($this->due_date)),
        'paymentMethod' => $this->payment_method
      ]);

      //Data Update
      $response['updated'] = [
        "title" => trans("icommerce::subscriptions.title.subscription updated",['id' => $this->id]),
        "message" => $message,
        "email" => $result['email'],
        "broadcast" => $result['broadcast'],
        "userId" => $userId,
        "source" => $source
      ];

    }

    return $response;
  }

}
