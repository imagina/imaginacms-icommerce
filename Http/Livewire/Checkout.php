<?php

namespace Modules\Icommerce\Http\Livewire;

use \Illuminate\Session\SessionManager;
use Livewire\Component;
use Illuminate\Http\Request;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Entities\Currency;
use Modules\Icommerce\Repositories\CartProductRepository;
use Modules\Icommerce\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;
use Modules\Icommerce\Transformers\OrderTransformer;
use Modules\Icommerce\Transformers\PaymentMethodTransformer;
use Modules\Icommerce\Transformers\ShippingMethodTransformer;
use Modules\Iprofile\Transformers\AddressTransformer;
use Illuminate\Support\Facades\Validator;

class Checkout extends Component
{
  
  protected $listeners = ['addressAdded', 'cartUpdated'];
  
  public $user;
  public $step;
  public $view;
  public $layout;
  public $order;
  public $cart;
  public $currency;
  public $requireShippingMethod;
  public $title;
  public $cartEmpty;
  public $useExistingOrNewPaymentAddress;
  public $billingAddressSelected;
  public $shippingAddressSelected;
  public $shippingMethodSelected;
  public $paymentMethodSelected;
  public $couponSelected;
  public $sameShippingAndBillingAddresses;
  public $locale;
  public $update;
  public $couponCode;
  
  protected $addresses;
  protected $products;
  protected $paymentMethods;
  protected $shippingMethods;
  
  public function mount(Request $request, $layout = 'one-page-checkout', $order = null, $cart = null,
                        $orderId = null, $cartId = null, $currency = null, $currencyId = null)
  {
    
    $this->couponSelected = null;
    $this->couponCode = null;
    $this->sameShippingAndBillingAddresses = true;
    $this->update = true;
    $this->locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
    $this->layout = $layout;
    
    $this->initTitle();
    $this->initUser();
    $this->initStep();
    $this->initOrder($order, $orderId);
    $this->initCart($cart, $cartId);
    $this->initCurrency($currency, $currencyId);
    $this->load();
    
    $this->view = "icommerce::frontend.livewire.checkout.layouts." . ($this->layout ?? 'one-page-checkout') . ".index";
    
  }
  
  /*
  |--------------------------------------------------------------------------
  | Inits
  |--------------------------------------------------------------------------
  */
  /**
   *
   */
  private function initTitle()
  {
    
    if (setting("icommerce::customCheckoutTitle")) {
      $this->title = setting("icommerce::customCheckoutTitle");
    } else {
      $this->title = trans('icommerce::checkout.title');
    }
    
  }
  
  /**
   *
   */
  private function initUser()
  {
    $this->user = \Auth::user();
  }
  
  /**
   *
   */
  public function initAddresses()
  {
    
    if (isset($this->user->id)) {
      $this->addresses = $this->user->addresses()->get() ?? [];
      
    } else {
      $this->addresses = collect([]);
    }
    
  }
  
  /**
   *
   */
  private function initStep()
  {
    
    $this->step = 1;
    if (isset($user->id))
      $this->step = 2;
    
  }
  
  /**
   * @param $order
   */
  private function initOrder($order, $orderId)
  {
    
    if (isset($order->id)) {
      $this->order = $order;
    } elseif (!empty($orderId)) {
      $order = $this->orderRepository()->getItem($orderId);
      
      $this->order = new OrderTransformer($order);
    } else {
      $this->order = null;
    }
    
  }
  
  /**
   *
   */
  public function initPaymentMethods()
  {
    
    $params = ["filter" => ["status" => 1]];
  
    $this->paymentMethods = $this->paymentMethodRepository()->getItemsBy(json_decode(json_encode($params)));
    
  }
  
  /**
   *
   */
  public function initShippingMethods()
  {
    
    $params = [];
    $data = ["cart_id" => $this->cart->id ?? null];
  
    $this->shippingMethods = $this->shippingMethodRepository()->getCalculations($data, json_decode(json_encode($params)));
    
  }
  
  /**
   * @param $cart
   * @param $cartId
   */
  private function initCart($cart = null, $cartId = null)
  {
    
    if (isset($cart->id)) {
      $this->cart = $cart;
    } else {
      $cart = request()->session()->get('cart');
      
      if (isset($cart->id) && $cart->status == 1) {
        
        $this->cart = $this->cartRepository()->getItem($cart->id);
        
      } elseif (!empty($cartId)) {
        
        $this->cart = $this->cartRepository()->getItem($cartId);
        
      } else {
        $this->cart = null;
      }
    }
    
    if(isset($this->cart->id)){
      $this->requireShippingMethod = $this->cart->require_shipping;
    }
    
  }
  
  /**
   * @param $currency
   * @param $currencyId
   */
  private function initCurrency($currency, $currencyId)
  {
    if (isset($currency->id)) {
      $this->currency = $currency;
    } elseif (!empty($currencyId)) {
      $this->currency = $this->currencyRepository()->getItem($currencyId);
    } else {
      $this->currency = Currency::where("default_currency", 1)->first();
    }
    
    
  }
  
  /**
   *
   */
  private function initProducts()
  {
    $this->cartEmpty = true;
    if (isset($this->cart->id)) {
      $this->products = $this->cart->products->pluck('product');
    } elseif (isset($this->order->id)) {
      $this->products = $this->order->orderItems->pluck('product');
    } else {
      $this->products = collect([]);
    }
    
    if ($this->products->isNotEmpty())
      $this->cartEmpty = false;
  }
  
  
  /*
   |--------------------------------------------------------------------------
   | Livewire Events
   |--------------------------------------------------------------------------
   */
  /**
   *
   */
  public function hydrate()
  {
    $this->load();
  }
  
  /**
   * @param $name
   * @param $value
   */
  public function updated($name, $value)
  {

    switch ($name) {
      case 'sameShippingAndBillingAddresses':
        if ($value) {
          $this->shippingAddressSelected = $this->billingAddressSelected;
        } else {
          $this->shippingAddressSelected = null;
          $this->getShippingAddressProperty();
        }
        break;
        
      case 'billingAddressSelected':
        if($this->sameShippingAndBillingAddresses){
          $this->shippingAddressSelected = $this->billingAddressSelected;
        }
        break;
    }
    
  }
  
  
  /*
   |--------------------------------------------------------------------------
   | Event's Action
   |--------------------------------------------------------------------------
   */
  /**
   *
   */
  public function addressAdded($address)
  {
    $this->initAddresses();
    switch ($address["type"]) {
      case 'billing':
        if (isset($address["id"])) {
          $this->billingAddressSelected = $address["id"];
        }
        break;
      
      case 'shipping':
        if (isset($address["id"])) {
          $this->shippingAddressSelected = $address["id"];
        }
        break;
    }
    
  }
  
  /**
   * @param $cart
   */
  public function cartUpdated($cart)
  {
    $this->initCart(null, $cart["id"]);
    
  }
  
  /*
   |--------------------------------------------------------------------------
   | Repositories
   |--------------------------------------------------------------------------
   */
  /**
   * @return paymentMethodRepository
   */
  private function paymentMethodRepository()
  {
    return app('Modules\Icommerce\Repositories\PaymentMethodRepository');
  }
  
  /**
   * @return currencyRepository
   */
  private function currencyRepository()
  {
    return app('Modules\Icommerce\Repositories\CurrencyRepository');
  }
  
  /**
   * @return OrderRepository
   */
  private function orderRepository()
  {
    return app('Modules\Icommerce\Repositories\OrderRepository');
  }
  
  /**
   * @return cartRepository
   */
  private function cartRepository()
  {
    return app('Modules\Icommerce\Repositories\CartRepository');
  }
  
  /**
   * @return cartRepository
   */
  private function couponRepository()
  {
    return app('Modules\Icommerce\Repositories\CouponRepository');
  }
  
  /**
   * @return shippingMethodRepository
   */
  private function shippingMethodRepository()
  {
    return app('Modules\Icommerce\Repositories\ShippingMethodRepository');
  }
  /**
   * @return orderService
   */
  private function orderService()
  {
    return app('Modules\Icommerce\Services\OrderService');
  }
  
  /*
  |--------------------------------------------------------------------------
  | Supports
  |--------------------------------------------------------------------------
  */
  /**
   * @return orderSupport
   */
  private function orderSupport()
  {
    return app('Modules\Icommerce\Support\Order');
  }
  
  /*
  |--------------------------------------------------------------------------
  | Properties
  |--------------------------------------------------------------------------
  */
  /**
   * Computed Property - billingAddress
   * @return mixed
   */
  public function getBillingAddressProperty()
  {
    $billingAddress = null;
    
    if (isset($this->user->id)) {
      
      if (!empty($this->billingAddressSelected)) {
        $billingAddress = $this->addresses->where("id", $this->billingAddressSelected)->first();
      } else {
          $billingAddress = $this->addresses->where("type", "billing")->where("default", 1)->first();
  
          if (!isset($billingAddress->id) && $this->addresses->count()) {
            $billingAddress = $this->addresses->first();
          }
        
        
      }
      
    }
    if (isset($billingAddress->id)) $this->billingAddressSelected = $billingAddress->id;
    
    return $billingAddress;
  }
  
  /**
   * Computed Property - shippingAddress
   * @return mixed
   */
  public function getShippingAddressProperty()
  {
    $shippingAddress = null;
    
    if (isset($this->user->id)) {
      
      if (!empty($this->shippingAddressSelected)) {
        $shippingAddress = $this->addresses->where("id", $this->shippingAddressSelected)->first();
      } else {
        if($this->sameShippingAndBillingAddresses && !empty($this->billingAddressSelected)){
          
          $shippingAddress = $this->addresses->where("id", $this->billingAddressSelected)->first();
        }else {
          $shippingAddress = $this->addresses->where("type", "shipping")->where("default", 1)->first();
  
          if (!isset($shippingAddress->id) && $this->addresses->count()) {
            $shippingAddress = $this->addresses->first();
          }
        }
        
      }
      
    }
    if (isset($shippingAddress->id)) $this->shippingAddressSelected = $shippingAddress->id;
    
    return $shippingAddress;
  }
  
  /**
   * @return
   */
  public function getShippingMethodProperty()
  {
    $shippingMethod = null;
    
    if (isset($this->user->id)) {
      
      if (!empty($this->shippingMethodSelected)) {
        $shippingMethod = $this->shippingMethods->where("id", $this->shippingMethodSelected)->first();
      } else {
        
        if (!isset($shippingMethod->id) && $this->shippingMethods->count()) {
          $shippingMethod = $this->shippingMethods->first();
        }
      }
    }
    if (isset($shippingMethod->id)) $this->shippingMethodSelected = $shippingMethod->id;
    
    return $shippingMethod;
  }
  
  /**
   * @return
   */
  public function getTotalProperty()
  {
    $total = 0;
    
    //added cart total
    $total += $this->cart->total ?? 0;
    
    //added shipping method total
    $total += $this->shippingMethod->calculations->price ?? 0;
    
    //added tax - pending feature
    //-----------------------------------------------------------------------------------------------------------------
    
    //subtracted coupon - pending feature
    //-----------------------------------------------------------------------------------------------------------------
    
    return $total;
  }
  
  /**
   * @return
   */
  public function getPaymentMethodProperty()
  {
    $paymentMethod = null;
    
    if (isset($this->user->id)) {
      
      if (!empty($this->paymentMethodSelected)) {
        $paymentMethod = $this->paymentMethods->where("id", $this->paymentMethodSelected)->first();
      } else {
        
        if (!isset($paymentMethod->id) && $this->paymentMethods->count()) {
          $paymentMethod = $this->paymentMethods->first();
        }
      }
    }
    if (isset($paymentMethod->id)) $this->paymentMethodSelected = $paymentMethod->id;
    
    return $paymentMethod;
  }
  
  /*
  |--------------------------------------------------------------------------
  | Custom Actions
  |--------------------------------------------------------------------------
  */
  /**
   * @param $couponCode
   */
  public function validateCoupon($couponCode)
  {
    
    $params = ["filter" => ["field" => "code"]];
    $coupon = $this->couponRepository()->getItem($couponCode, json_decode(json_encode($params)));
    
    if (!isset($coupon->id)) {
      $this->alert('warning', trans('icommerce::coupons.messages.coupon not exist'), config("asgard.isite.config.livewireAlerts"));
    }else{
      if(!$coupon->isValid){
        $this->alert('warning', trans('icommerce::coupons.messages.coupon inactive'), config("asgard.isite.config.livewireAlerts"));
      }else{
        $this->couponSelected = $coupon->id;
      }
    }
    
  }
  
  /**
   *
   */
  protected function load()
  {
    $this->initAddresses();
    $this->initProducts();
    $this->initPaymentMethods();
    $this->initShippingMethods();
    $this->getBillingAddressProperty();
    $this->getShippingAddressProperty();
  }
  
  /**
   *
   */
  public function submit(Request $request)
  {
    
    $validatedData = Validator::make(
      [
        'userId' => $this->user->id ?? null,
        'billingAddress' => $this->billingAddressSelected,
        'shippingAddress' => $this->shippingAddressSelected,
        'paymentMethod' => $this->paymentMethodSelected,
        'shippingMethod' => $this->shippingMethodSelected,
        ],
      [
        'userId' => 'required',
        'billingAddress' => 'required',
        'shippingAddress' => 'required',
        'paymentMethod' => 'required',
        'shippingMethod' => 'required',
      ]
        )->validate();
  
    $orderService = app("Modules\Icommerce\Services\OrderService");
    $data = [];
    
    $data["cart"] = $this->cart;
    $data["customer"] = $this->user;
    $data["addedBy"] = $this->user;
    $data["shippingAddress"] = $this->shippingAddress;
    $data["billingAddress"] = $this->billingAddress;
    $data["shippingMethod"] = $this->shippingMethod;
    $data["paymentMethod"] = $this->paymentMethod;

    if(!isset($this->order->id)){
      $orderData = $orderService->create($data);

      if(isset($orderData["orderId"])){
        $this->alert('success', trans('icommerce::orders.messages.order success'), config("asgard.isite.config.livewireAlerts"));
        $this->emit("orderCreated",$orderData);
        $this->emit("deleteCart");
      }else{
        $this->alert('warning', trans('icommerce::orders.messages.order error'), config("asgard.isite.config.livewireAlerts"));
      }
    }
  }
  
  /*
  |--------------------------------------------------------------------------
  | Render
  |--------------------------------------------------------------------------
  */
  /**
   * @return mixed
   */
  public function render()
  {
    
    return view($this->view, [
      "user" => $this->user,
      "addresses" => $this->addresses,
      "order" => $this->order,
      "cart" => $this->cart,
      "products" => $this->products,
      "paymentMethods" => $this->paymentMethods,
      "shippingMethods" => $this->shippingMethods,
      "currency" => $this->currency
    ]);
    
  }
}
