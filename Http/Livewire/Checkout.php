<?php

namespace Modules\Icommerce\Http\Livewire;

use \Illuminate\Session\SessionManager;
use Livewire\Component;
use Illuminate\Http\Request;
use Modules\Icommerce\Entities\CartProduct;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Entities\Currency;
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Repositories\CartProductRepository;
use Modules\Icommerce\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;
use Modules\Icommerce\Transformers\OrderTransformer;
use Modules\Icommerce\Transformers\PaymentMethodTransformer;
use Modules\Icommerce\Transformers\ShippingMethodTransformer;
use Modules\Iprofile\Transformers\AddressTransformer;
use Illuminate\Support\Facades\Validator;
use Modules\Icommerce\Support\Coupon as SupportCoupon;
use Illuminate\Support\Str;
use Modules\User\Entities\Sentinel\User as entityUser;
use Modules\Iprofile\Entities\Address as Address;

class Checkout extends Component
{

  protected $listeners = ['addressAdded', 'cartUpdated', 'emitCheckoutAddressBilling',
    'emitCheckoutAddressShipping', 'editAddressBillingEmit', 'editAddressShippingEmit'];

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
  public $organization;
  public $userEmail;
  public $shopAsGuest;
  public $guestShopOnly;
  public $addressGuest;
  public $addressGuestShipping;
  public $addressGuestBillingCreated;
  public $addressGuestShippingCreated;
  protected $addresses;

  protected $taxes;
  protected $products;
  protected $paymentMethods;
  protected $shippingMethods;
  protected $couponDiscount;


  public function mount(Request $request, $layout = null, $order = null, $cart = null,
                                $orderId = null, $cartId = null, $currency = null, $currencyId = null)
  {
    $this->couponSelected = null;
    $this->couponCode = null;
    $this->taxes = [];
    $this->sameShippingAndBillingAddresses = true;
    $this->update = true;
    $this->locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
    $user = Auth::user();

    if (isset($user)) {
      $this->shopAsGuest = false;
    } else {
      $this->shopAsGuest = setting('icommerce::guestPurchasesByDefault');
    }

    if (setting('icommerce::guestShopOnly')) {
      $this->shopAsGuest = true;
      $this->guestShopOnly = setting('icommerce::guestShopOnly');

    }

    $this->addressGuestShipping = [];
    $this->addressGuest = [];
    $this->addressGuestBillingCreated = false;
    $this->addressGuestShippingCreated = false;


    $this->layout = $layout ?? setting("icommerce::checkoutLayout");

    $this->initTitle();
    $this->initUser();
    $this->initOrganization();
    $this->initStep();
    $this->initOrder($order, $orderId);
    $this->initCart($cart, $cartId);
    $this->initCurrency($currency, $currencyId);
    $this->load();

    $this->view = "icommerce::frontend.livewire.checkout.index";

  }

  //|--------------------------------------------------------------------------
  //| User guests
  //|--------------------------------------------------------------------------
  public function editAddressBillingEmit()
  {
    $this->addressGuestBillingCreated = false;
  }

  public function editAddressShippingEmit()
  {
    $this->addressGuestShippingCreated = false;
  }

  public function emitCheckoutAddressBilling($data)
  {
    $this->addressGuest = $data;
    $this->addressGuestBillingCreated = true;

    if ($this->sameShippingAndBillingAddresses) {
      $data['type'] = 'shipping';
      $this->addressGuestShipping = $data;
      $this->addressGuestShippingCreated = true;
    }

    $this->alert('success', trans('iprofile::addresses.messages.created'), config("asgard.isite.config.livewireAlerts"));
  }

  public function emitCheckoutAddressShipping($data)
  {
    $this->addressGuestShipping = $data;
    $this->addressGuestShippingCreated = true;

    $this->alert('success', trans('iprofile::addresses.messages.created'), config("asgard.isite.config.livewireAlerts"));
  }

  public function createUserGuest()
  {
    $userdata['email'] = $this->userEmail;
    $userdata['password'] = Str::random(32);
    $userdata['first_name'] = $this->addressGuest['first_name'];
    $userdata['last_name'] = $this->addressGuest['last_name'];
    $userdata["is_activated"] = true;
    $userdata['is_guest'] = true;
    $role = $this->roleRepository()->findByName(config('asgard.user.config.default_role', 'User'));
    $this->user = entityUser::where('email', $userdata['email'])->first();
    if (!$this->user) {
      $this->user = $this->userRepository()->createWithRoles($userdata, [$role->id], $userdata["is_activated"]);
    }
  }

  public function shopAsGuest()
  {
    if ($this->shopAsGuest == false) {
      $this->shopAsGuest = true;
    } else {
      $this->shopAsGuest = false;
    }
  }

  //|--------------------------------------------------------------------------
  //| Inits
  //|--------------------------------------------------------------------------
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
    if (isset($this->user->id))
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

  public function initOrganization()
  {

    $this->organization = null;
    if (function_exists('tenant') && isset(tenant()->id)) {
      $this->organization = tenant();
    }

  }

  /**
   *
   */
  public function initPaymentMethods()
  {

    $params = ["filter" => ["status" => 1, "withCalculations" => true, "cartId" => $this->cart->id ?? null]];

    $this->paymentMethods = $this->paymentMethodRepository()->getItemsBy(json_decode(json_encode($params)));

    // Validate if the Shipping Method selected has an status error to deactivated
    $paymentMethod = $this->paymentMethods->where("id", $this->paymentMethodSelected)->first();

    if (isset($paymentMethod->id) && isset($paymentMethod->calculations->status) && $paymentMethod->calculations->status == "error") {
      $this->paymentMethodSelected = null;
    }
  }

  /**
   *
   */
  public function initShippingMethods()
  {

    //\Log::info('Icommerce: Livewire|Checkout|InitShippingMethods');

    $params = [];
    $data = ["cart_id" => $this->cart->id ?? null];

    $data['shippingAddressId'] = $this->shippingAddressSelected;

    $this->shippingMethods = $this->shippingMethodRepository()->getCalculations($data, json_decode(json_encode($params)));

    // Validate if the Shipping Method selected has an status error to deactivated
    $shippingMethod = $this->shippingMethods->where("id", $this->shippingMethodSelected)->first();

    if (isset($shippingMethod->id) && isset($shippingMethod->calculations->status) && $shippingMethod->calculations->status == "error")
      $this->shippingMethodSelected = null;


  }

  /**
   * @param $cart
   * @param $cartId
   */
  private function initCart($cart = null, $cartId = null)
  {

    $cart = request()->session()->get('cart');

    if (isset($cart->id) && $cart->status == 1) {

      $this->cart = $this->cartRepository()->getItem($cart->id);

    } else {
      $this->cart = $this->cartService()->create(["cart" => $cart, "cartId" => $cartId]);
    }


    if (isset($this->cart->id)) {
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

  private function initTaxes()
  {

    $this->taxes = $this->cartService()->totalTaxes(["cart" => $this->cart, "couponDiscounts" => $this->couponDiscount->allDiscounts ?? []]);

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

  //|--------------------------------------------------------------------------
  //| Livewire Events
  //|--------------------------------------------------------------------------
  /**
   *
   */
  public function hydrate()
  {
    //\Log::info('Icommerce: Livewire|Checkout|Hydrate');
    $this->load();
  }

  /**
   * @param $name
   * @param $value
   */
  public function updated($name, $value)
  {

    //\Log::info('Icommerce: Livewire|Checkout|Updated');

    switch ($name) {
      case 'sameShippingAndBillingAddresses':
        if ($value) {
          if (isset($this->addressGuest['first_name'])) {
            $this->addressGuestShippingCreated = true;
            $this->addressGuestShipping = $this->addressGuest;
            $this->addressGuestShipping['type'] = 'shipping';
          }
          $this->shippingAddressSelected = $this->billingAddressSelected;
        } else {
          $this->addressGuestShippingCreated = false;
          $this->shippingAddressSelected = null;
          $this->addressGuestShipping = null;
          $this->getShippingAddressProperty();
        }
        break;

      case 'billingAddressSelected':
        if ($this->sameShippingAndBillingAddresses) {
          $this->shippingAddressSelected = $this->billingAddressSelected;
        }
        break;
    }

  }

  //|--------------------------------------------------------------------------
  //| Event's Action
  //|--------------------------------------------------------------------------
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

        if ($this->sameShippingAndBillingAddresses) {
          $this->shippingAddressSelected = $this->billingAddressSelected;
        }

        break;

      case 'shipping':
        if (isset($address["id"])) {
          $this->shippingAddressSelected = $address["id"];
        }
        break;
    }

    // Initializing shipping methods sending the new addresses selected if there are another calculations by each shipping method
    $this->initShippingMethods();

  }

  /**
   * @param $cart
   */
  public function cartUpdated($cart)
  {
    $this->initCart(null, $cart["id"]);

  }

  //|--------------------------------------------------------------------------
  //| Repositories
  //|--------------------------------------------------------------------------
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

  private function roleRepository()
  {
    return app('Modules\User\Repositories\RoleRepository');
  }

  private function userRepository()
  {
    return app('Modules\User\Repositories\UserRepository');
  }

  //|--------------------------------------------------------------------------
  //| Services
  //|--------------------------------------------------------------------------
  /**
   * @return orderService
   */
  private function orderService()

  {
    return app('Modules\Icommerce\Services\OrderService');
  }

  /**
   * @return orderService
   */
  private function cartService()
  {
    return app('Modules\Icommerce\Services\CartService');
  }

  //|--------------------------------------------------------------------------
  //| Supports
  //|--------------------------------------------------------------------------
  /**
   * @return orderSupport
   */
  private function orderSupport()
  {
    return app('Modules\Icommerce\Support\Order');
  }

  //|--------------------------------------------------------------------------
  //| Properties
  //|--------------------------------------------------------------------------
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
        if ($this->sameShippingAndBillingAddresses && !empty($this->billingAddressSelected)) {

          $shippingAddress = $this->addresses->where("id", $this->billingAddressSelected)->first();
        } else {
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

    if (!empty($this->shippingMethodSelected)) {

      $shippingMethod = $this->shippingMethods->where("id", $this->shippingMethodSelected)->first();
    } else {

      if ($this->shippingMethods->count() && $this->shippingMethods->count() == 1) {
        $shippingMethod = $this->shippingMethods->first();
      }

    }
    if (isset($shippingMethod->id)) $this->shippingMethodSelected = $shippingMethod->id;

    return $shippingMethod;
  }

  /**
   * @return
   */
  public function getTotalTaxesProperty()
  {
    $totalTaxes = [];

    foreach ($this->taxes as $productTaxes) {
      foreach ($productTaxes as $productTax) {
        $totalTaxes[$productTax["rateId"]] = [
          "rateId" => $productTax["rateId"],
          "rateName" => $productTax["rateName"],
          "rate" => $productTax["rateType"] == 1 ? round($productTax["rate"]) . "%" :
            (isset($this->currency->id) ? $this->currency->symbol_left : '$') .
            formatMoney($productTax["rate"]) .
            (isset($this->currency->id) ? $this->currency->symbol_right : ''),
          "totalTax" => ($totalTaxes[$productTax["rateId"]]["totalTax"] ?? 0) + $productTax["tax"]
        ];
      }
    }

    return $totalTaxes;
  }


  /**
   * @return
   */
  public function getTotalProperty()
  {
    $total = 0;

    //added cart total
    $total += $this->cart->total ?? 0;

    //subtracted coupon amount
    //-----------------------------------------------------------------------------------------------------------------
    if (isset($this->couponSelected->id)) {
      $total -= $this->couponDiscount->discount ?? 0;
    }

    //added taxes
    //-----------------------------------------------------------------------------------------------------------------
    foreach ($this->totalTaxes as $totalTax) {
      $total += $totalTax["totalTax"];
    }

    //added shipping method total
    $total += $this->shippingMethod->calculations->price ?? 0;


    return $total;
  }

  /**
   * @return
   */
  public function getPaymentMethodProperty()
  {
    $paymentMethod = null;

    if (!empty($this->paymentMethodSelected)) {
      $paymentMethod = $this->paymentMethods->where("id", $this->paymentMethodSelected)->first();
    } else {
      if ($this->paymentMethods->count() && $this->paymentMethods->count() == 1) {
        $paymentMethod = $this->paymentMethods->first();
      }
    }

    if (isset($paymentMethod->id)) $this->paymentMethodSelected = $paymentMethod->id;

    if (isset($paymentMethod->id) && isset($paymentMethod->calculations->status) && $paymentMethod->calculations->status == "error") {
      $this->paymentMethodSelected = $paymentMethod = null;
    }
    return $paymentMethod;
  }

  //|--------------------------------------------------------------------------
  //| Custom Actions
  //|--------------------------------------------------------------------------
  public function setStep($step)
  {
    $this->step = $step;
  }

  /**
   * @param $couponCode
   */
  public function validateCoupon($couponCode)
  {

    $params = ["filter" => ["field" => "code"]];
    $coupon = $this->couponRepository()->getItem($couponCode, json_decode(json_encode($params)));

    //validate if the coupon exist
    if (!isset($coupon->id)) {
      $this->alert('warning', trans('icommerce::coupons.messages.coupon not exist'), config("asgard.isite.config.livewireAlerts"));
    } else {
      //validate if the coupon its running yet
      if (!$coupon->running) {
        $this->alert('warning', trans('icommerce::coupons.messages.coupon inactive'), config("asgard.isite.config.livewireAlerts"));
        //validate if the coupon can be used by de user logged
      } elseif (!$coupon->canUse) {
        $this->alert('warning', trans('icommerce::coupons.messages.cantUseThisCoupon'), config("asgard.isite.config.livewireAlerts"));
      } else {

        //coupon Support
        $validateCoupons = new SupportCoupon();
        //getting the discount details by the products in the cart
        $result = $validateCoupons->getDiscount($coupon, $this->cart->id);

        //if the coupon return status 1 the coupon its applied
        if ($result->status == 1) {

          $this->alert('success', trans('icommerce::coupons.messages.couponApplied'), config("asgard.isite.config.livewireAlerts"));
          $this->couponSelected = $coupon;
          $this->couponDiscount = $result;
          $this->initTaxes();
          $this->getTotalTaxesProperty();

        } else {
          //if the coupon return status 0 the coupon cant be applied
          $this->alert('warning', trans($result->message), config("asgard.isite.config.livewireAlerts"));
        }
      }
    }

  }

  public function getCouponDiscount()
  {

    if (isset($this->couponSelected->id)) {
      $validateCoupons = new SupportCoupon();
      $this->couponDiscount = $validateCoupons->getDiscount($this->couponSelected, $this->cart->id);
    }
  }

  /**
   *
   */
  protected function load()
  {
    $this->initAddresses();
    $this->initProducts();

    $this->getBillingAddressProperty();
    $this->getShippingAddressProperty();

    // Fixed Bug first request selected address
    $this->initShippingMethods();
    $this->initPaymentMethods();

    $this->getPaymentMethodProperty();
    $this->getShippingMethodProperty();

    $this->getCouponDiscount();
    $this->initTaxes();
    $this->getTotalTaxesProperty();

  }

  /**
   *
   */
  public function submit(Request $request)
  {

    //\Log::info('Icommerce: Livewire|Checkout|Submit - INIT');
    try {
      if ($this->shopAsGuest & !empty($this->addressGuest)) {
        $validatedData = Validator::make(
          array_merge([
            'billingAddress' => count($this->addressGuest),
            'email' => $this->userEmail,
            'paymentMethod' => $this->paymentMethodSelected,
          ], ($this->requireShippingMethod ? [
            'shippingMethod' => $this->shippingMethodSelected,
            'shippingAddress' => count($this->addressGuestShipping),
          ] : [])),
          array_merge([
            'email' => 'required|email',
            'billingAddress' => 'required',
            'paymentMethod' => 'required',
          ], ($this->requireShippingMethod ? [
            'shippingMethod' => 'required',
            'shippingAddress' => 'required',
          ] : [])),
          array_merge([
            'email.required' => trans("icommerce::checkout.alerts.login_order"),
            'email.email' => trans("icommerce::checkout.alerts.login_order"),
            'billingAddress.required' => trans("icommerce::checkout.messages.billing_address"),
            'paymentMethod.required' => trans("icommerce::checkout.messages.payment_method")
          ], ($this->requireShippingMethod ? [
            'shippingMethod.required' => trans("icommerce::checkout.messages.shipping_method"),
            'shippingAddress.required' => trans("icommerce::checkout.messages.shipping_address"),
          ] : []))
        )->validate();
        $this->createUserGuest();
        $billingAddressGuest = Address::create(array(
          'user_id' => $this->user->id,
          'first_name' => $this->addressGuest['first_name'],
          'last_name' => $this->addressGuest['last_name'],
          'address_1' => $this->addressGuest['address_1'],
          'telephone' => $this->addressGuest['telephone'],
          'country' => $this->addressGuest['country'],
          'country_id' => $this->addressGuest['country_id'],
          'state' => $this->addressGuest['address_1'],
          'state_id' => $this->addressGuest['state_id'],
          'city' => $this->addressGuest['city'],
          'city_id' => $this->addressGuest['city_id'],
          'default' => $this->addressGuest['default'],
          'type' => $this->addressGuest['type'],
          'options' => $this->addressGuest['options'],
        ));
        $this->billingAddressSelected = $billingAddressGuest->id;
        if ($this->requireShippingMethod & !$this->sameShippingAndBillingAddresses) {
          $shippingAddressGuest = Address::create(array(
            'user_id' => $this->user->id,
            'first_name' => $this->addressGuestShipping['first_name'],
            'last_name' => $this->addressGuestShipping['last_name'],
            'address_1' => $this->addressGuestShipping['address_1'],
            'telephone' => $this->addressGuestShipping['telephone'],
            'country' => $this->addressGuestShipping['country'],
            'country_id' => $this->addressGuestShipping['country_id'],
            'state' => $this->addressGuestShipping['address_1'],
            'state_id' => $this->addressGuestShipping['state_id'],
            'city' => $this->addressGuestShipping['city'],
            'city_id' => $this->addressGuestShipping['city_id'],
            'default' => $this->addressGuestShipping['default'],
            'type' => $this->addressGuestShipping['type'],
            'options' => $this->addressGuestShipping['options'],
          ));
          $this->shippingAddressSelected = $shippingAddressGuest->id;
        } else {
          $this->shippingAddressSelected = $billingAddressGuest->id;
        }
        $this->initAddresses();
      } else {
        $validatedData = Validator::make(
          array_merge([
            'userId' => $this->user->id ?? null,
            'billingAddress' => $this->billingAddressSelected,
            'paymentMethod' => $this->paymentMethodSelected,
          ], ($this->requireShippingMethod ? [
            'shippingMethod' => $this->shippingMethodSelected,
            'shippingAddress' => $this->shippingAddressSelected,
          ] : [])),
          array_merge([
            'userId' => 'required',
            'billingAddress' => 'required',
            'paymentMethod' => 'required',
          ], ($this->requireShippingMethod ? [
            'shippingMethod' => 'required',
            'shippingAddress' => 'required',
          ] : [])),
          array_merge([
            'userId.required' => trans("icommerce::checkout.alerts.login_order"),
            'billingAddress.required' => trans("icommerce::checkout.messages.billing_address"),
            'paymentMethod.required' => trans("icommerce::checkout.messages.payment_method")
          ], ($this->requireShippingMethod ? [
            'shippingMethod.required' => trans("icommerce::checkout.messages.shipping_method"),
            'shippingAddress.required' => trans("icommerce::checkout.messages.shipping_address"),
          ] : []))
        )->validate();
      }

    } catch (\Illuminate\Validation\ValidationException $e) {
      // Do your thing and use $validator here
      $validator = $e->validator;

      $this->alert('warning', trans("icommerce::checkout.alerts.missing_fields"), config("asgard.isite.config.livewireAlerts"));

      // Once you're done, re-throw the exception
      throw $e;
    }

    $orderService = app("Modules\Icommerce\Services\OrderService");
    $data = [];

    $data["cart"] = $this->cart;
    $data["customer"] = $this->user;
    $data["addedBy"] = $this->user;
    $data["shippingAddress"] = $this->shippingAddress;
    $data["billingAddress"] = $this->billingAddress;
    $data["shippingMethod"] = $this->shippingMethod;
    $data["paymentMethod"] = $this->paymentMethod;
    $data["coupon"] = $this->couponSelected;
    $data["guest_purchase"] = $this->shopAsGuest;


    if (!isset($this->order->id)) {
      \Log::info('Icommerce: Livewire|Checkout|Submit|OrderService Create');
      $orderData = $orderService->create($data);
      if (isset($orderData["orderId"])) {
        $this->alert('success', trans('icommerce::orders.messages.order success'), config("asgard.isite.config.livewireAlerts"));
        $this->emit("orderCreated", $orderData);
        $this->emit("deleteCart");
      } else {
        $this->alert('warning', trans('icommerce::orders.messages.order error'), config("asgard.isite.config.livewireAlerts"));
        \Log::info('Icommerce: Livewire|Checkout|Submit|Error: Order Data:' . json_encode($orderData));
      }
    }

    //\Log::info('Icommerce: Livewire|Checkout|Submit - END');
  }

  //|--------------------------------------------------------------------------
  //| Render
  //|--------------------------------------------------------------------------
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
      "couponDiscount" => $this->couponDiscount,
      "paymentMethods" => $this->paymentMethods,
      "shippingMethods" => $this->shippingMethods,
      "currency" => $this->currency
    ]);
  }
}
