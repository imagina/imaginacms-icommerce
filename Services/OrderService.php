<?php


namespace Modules\Icommerce\Services;

use Modules\Icommerce\Events\OrderWasCreated;
use Modules\Icommerce\Repositories\CartRepository;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Support\OrderHistory as orderHistorySupport;
use Modules\Icommerce\Support\OrderItem as orderItemSupport;
use Modules\Icommerce\Support\Coupon as validateCoupons;
use Modules\Iprofile\Repositories\UserApiRepository;
use Modules\Icommerce\Repositories\CartProductRepository;
use Illuminate\Http\Request;

class OrderService
{
  
  public function __construct(
    OrderRepository $order,
    CartRepository $cart,
    CartProductRepository $cartProduct,
    UserApiRepository $user,
    CartService $cartService
  )
  {
    $this->order = $order;
    $this->cart = $cart;
    $this->cartProduct = $cartProduct;
    $this->user = $user;
    $this->cartService = $cartService;
  }
  
  /**
   * CREATE A ITEM
   *
   * @param Request $request
   * @return mixed
   */
  public function create($data)
  {
    \DB::beginTransaction();
     try {
    $orderData = [];
    $orderData["options"] = [];
    $total = [];

    /*
    |--------------------------------------------------------------------------
    | Validate customer and addedBy user
    |--------------------------------------------------------------------------
    */
    if (isset($data["customer"])) {
      $customer = $data["customer"];
      
      
    } elseif (isset($data["customerId"])) {
      $customer = $this->user->find($data["customerId"]);
    }
    
    //Validating AddedBy
    if (isset($data["addedBy"])) {
      $addedBy = $data["addedBy"];
    } elseif (isset($data["addedById"])) {
      $addedBy = $this->user->find($data["addedById"]);
    } else {
      $addedBy = \Auth::user();
    }
    
    //Break if the data is empty
     if(!isset($data["type"]) || (isset($data["type"]) && !$data["type"]=="quote"))
       if(!isset($customer->id) || !isset($addedBy->id)){
         \Log::info("[ERROR/Exception]:: Missing customer or addedBy user | OrderService::73");
         throw new \Exception('Missing customer or addedBy user', 400);
       }
    
    /*
    |--------------------------------------------------------------------------
    | getting the customer data
    |--------------------------------------------------------------------------
    */
    
    $orderData["customer_id"] = $customer->id ?? null;
    $orderData["added_by_id"] = $addedBy->id ?? null;
    
    $orderData["first_name"] = $customer->first_name ?? $data["first_name"] ?? null;
    $orderData["last_name"] = $customer->last_name ?? $data["last_name"] ?? null;
    $orderData["email"] = $customer->email  ?? $data["email"] ?? null;

    if(isset($customer->id)){
      $telephone = $customer->fields()->where("name", "cellularPhone")->first();
      $orderData["telephone"] = $telephone->value ?? "";

      //Getting user addresses
      $addresses = $customer->addresses()->get() ?? [];
    }else{
      $orderData["telephone"] = $data["telephone"] ?? null;
      $addresses = [];
    }

    /*
    |--------------------------------------------------------------------------
    | Validate cart or create a new
    |--------------------------------------------------------------------------
    */
    $cart = $this->cartService->create($data);
    
    //Break if cart no found
    if (!isset($cart->id)){
      \Log::info("[ERROR/Exception]:: There are an error with the cart | OrderService::110");
      throw new \Exception('There are an error with the cart', 400);
    }
    
    $total = (($data["type"] ?? '') == "quote") ? $cart->products->sum('total') : $cart->total;
    /*
    |--------------------------------------------------------------------------
    | getting shipping address if issset in the data
    |--------------------------------------------------------------------------
    */
    
    if (isset($data["shippingAddress"]) || isset($data["shippingAddressId"])) {
      $shippingAddress = $data["shippingAddress"] ??
        (isset($data["shippingAddressId"]) ? $addresses->where("id", $data["shippingAddressId"]) :
          $addresses->where("type", "shipping")->where("default", 1)->first());
      
      if (isset($shippingAddress->id)) {
        $orderData["shipping_first_name"] = $shippingAddress->first_name;
        $orderData["shipping_last_name"] = $shippingAddress->last_name;
        $orderData["shipping_address_1"] = $shippingAddress->address_1;
        $orderData["shipping_address_2"] = $shippingAddress->address_2;
        $orderData["shipping_city"] = $shippingAddress->city;
        $orderData["shipping_zip_code"] = $shippingAddress->zip_code ?? "";
        $orderData["shipping_country_code"] = $shippingAddress->country;
        $orderData["shipping_zone"] = $shippingAddress->state;
        $orderData["shipping_telephone"] = $shippingAddress->telephone ?? "";
        $orderData["options"]["shippingAddress"] = $shippingAddress->options;
      }
    }
    
    /*
    |--------------------------------------------------------------------------
    | getting billing address if issset in the data
    |--------------------------------------------------------------------------
    */
    if (isset($data["billingAddress"]) || isset($data["billingAddressId"])) {
      $billingAddress = $data["billingAddress"] ??
        (isset($data["billingAddressId"]) ? $addresses->where("id", $data["billingAddressId"]) :
          $addresses->where("type", "billing")->where("default", 1)->first());
      
      if (isset($billingAddress->id)) {
        $orderData["payment_first_name"] = $billingAddress->first_name;
        $orderData["payment_last_name"] = $billingAddress->last_name;
        $orderData["payment_address_1"] = $billingAddress->address_1;
        $orderData["payment_address_2"] = $billingAddress->address_2;
        $orderData["payment_city"] = $billingAddress->city;
        $orderData["payment_zip_code"] = $billingAddress->zip_code ?? "";
        $orderData["payment_country"] = $billingAddress->country;
        $orderData["payment_zone"] = $billingAddress->state;
        $orderData["payment_telephone"] = $billingAddress->telephone ?? "";
        $orderData["options"]["billingAddress"] = $billingAddress->options;
      }
    }
    
    /*
   |--------------------------------------------------------------------------
   | getting discount from a coupon
   |--------------------------------------------------------------------------
   */
    $coupon = null;
    $couponResult = null;
    if (isset($data["coupon"]->id)) {
      $coupon = $data["coupon"];
    } else {
      $couponRepository = app("Modules\Icommerce\Repositories\CouponRepository");
      if (isset($data["couponCode"])) {
        $params = ["filter" => ["field" => "code"]];
        $coupon = $couponRepository->getItem($data["couponCode"], json_decode(json_encode($params)));
      } elseif (isset($data["couponId"])) {
        $coupon = $couponRepository->getItem($data["couponId"], json_decode(json_encode([])));
      }
    }
    if (isset($coupon->id)) {
      $validateCoupons = new validateCoupons();
      $couponResult = $validateCoupons->getDiscount($coupon, $cart->id);
      if ($couponResult->status == 1) {
        $total -= $couponResult->discount;
      }
    }

    /*
    |--------------------------------------------------------------------------
    | getting shipping method if issset in the data
    |--------------------------------------------------------------------------
    */
    if (isset($data["shippingMethod"]->id) || isset($data["shippingMethodId"])) {
      $shippingMethodRepository = app("Modules\Icommerce\Repositories\ShippingMethodRepository");
      
     
      $shippingMethods = $shippingMethodRepository->getCalculations(["cart_id" => $cart->id ?? null], json_decode(json_encode([])));
      
      $shippingMethod = $shippingMethods->where("id", $data["shippingMethod"]->id ?? $data["shippingMethodId"])->first();
      
      if(isset($shippingMethod->calculations->status) && $shippingMethod->calculations->status == "error"){
        \Log::info("[ERROR/Exception]::". $shippingMethod->calculations->msj ?? "Error with the Shipping Method");
        throw new \Exception($shippingMethod->calculations->msj ?? "Error with the Shipping Method", 400);
      }
      
      if (isset($shippingMethod->id)) {
        $orderData["shipping_method"] = $shippingMethod->title;
        $orderData["shipping_code"] = $shippingMethod->id;
        $orderData["shipping_amount"] = $shippingMethod->calculations->price ?? 0;
        
        //updated order total
        $total = $total + $orderData["shipping_amount"];
      }
    }
    
    /*
     |--------------------------------------------------------------------------
     | getting payment method if issset in the data
     |--------------------------------------------------------------------------
     */
    if (isset($data["paymentMethod"]->id) || isset($data["paymentMethodId"])) {
    
        $paymentMethodRepository = app('Modules\Icommerce\Repositories\PaymentMethodRepository');
  
        $params = ["filter" => ["status" => 1,"withCalculations" => true, "cartId" => $cart->id ?? null]];
    
        $paymentMethods = $paymentMethodRepository->getItemsBy(json_decode(json_encode($params)));
  
        $paymentMethod = $paymentMethods->where("id",$data["paymentMethod"]->id ?? $data["paymentMethodId"])->first();

        if(isset($paymentMethod->calculations->status) && $paymentMethod->calculations->status=="error"){
          \Log::info("[ERROR/Exception]::". $paymentMethod->calculations->msj ?? "Error with the Payment Method");
          throw new \Exception($paymentMethod->calculations->msj ?? "Error with the Payment Method", 400);
        }
    }
  
    if (isset($paymentMethod->id)) {
      $orderData["payment_code"] = $paymentMethod->id;
      $orderData["payment_method"] = $paymentMethod->title;
      
    }
 
    /*
    |--------------------------------------------------------------------------
    | getting currency if issset in the data
    |--------------------------------------------------------------------------
    */
    $currencyRepository = app('Modules\Icommerce\Repositories\CurrencyRepository');
    if (isset($data["currency"]->id)) {
      $currency = $data["currency"];
    } elseif (isset($data["currencyId"]) && !empty($data["currencyId"])) {
      $currency = $currencyRepository->getItem($data["currencyId"]);
    } else {
      $currency = $currencyRepository->findByAttributes(["default_currency" => 1]);
    }
    
    // Set Currency
    if (isset($currency->id)) {
      $orderData["currency_id"] = $currency->id;
      $orderData["currency_code"] = $currency->code;
      $orderData["currency_value"] = $currency->value;
    }
    
    /*
   |--------------------------------------------------------------------------
   | getting currency if issset in the data
   |--------------------------------------------------------------------------
   */
    if (isset($data["currency"]->id)) {
      $currency = $data["currency"];
    } elseif (isset($data["currencyId"]) && !empty($data["currencyId"])) {
      $currencyRepository = app('Modules\Icommerce\Repositories\CurrencyRepository');
      $currency = $currencyRepository->getItem($data["currencyId"]);
    } else {
      $currency = $currencyRepository->findByAttributes(["default_currency" => 1]);
    }
    
    // Set Currency
    if (isset($currency->id)) {
      $orderData["currency_id"] = $currency->id;
      $orderData["currency_code"] = $currency->code;
      $orderData["currency_value"] = $currency->value;
    }
  
  //validate options
       if(isset($data["options"])){
         $orderData["options"] = array_merge($orderData["options"],$data["options"]);
       }
    
    /*
    |--------------------------------------------------------------------------
    | Set others
    |--------------------------------------------------------------------------
    */
    $orderData["require_shipping"] = $cart->require_shipping;
    $orderData["status_id"] = 1;
    $orderData["total"] = $total;
   $orderData["type"] = $data["type"] ?? null;
    $orderData["user_agent"] = request()->header('User-Agent');
    $orderData["ip"] = request()->ip();//Set Ip from request
    $orderData['key'] = substr(md5(date("Y-m-d H:i:s") . request()->ip()), 0, 20);
    
    
    // Data Order History
    $supportOrderHistory = new orderHistorySupport(1, 1);
    $dataOrderHistory = $supportOrderHistory->getData();
    $orderData["orderHistory"] = $dataOrderHistory;
    
    // Data Order Items
    $supportOrderItem = new orderItemSupport();
    $dataOrderItem = $supportOrderItem->fixData($cart->products);
    $orderData["orderItems"] = $dataOrderItem;

    //Create order
    $order = $this->order->create($orderData);
    $dataResponse = [
      "cart" => $this->cart,
      "order" => $order,
      "orderId" => $order->id,
      "orderID" => $order->id, //TODO: fix icommerce extra methods because there are waiting the orderId like orderID
      "url" => $order->url,
      "key" => $order->key
    ];
    
    
    /*
    |--------------------------------------------------------------------------
    | Redeem Coupon
    |--------------------------------------------------------------------------
    */
    if (isset($couponResult->status) && $couponResult->status) {
      $validateCoupons->redeemCoupon($coupon->id, $order->id, $customer->id, $couponResult->discount);
    }
    
    
    /*
    |--------------------------------------------------------------------------
    | Getting payment Data
    |--------------------------------------------------------------------------
    */
    if (isset($paymentMethod->id)) {
      $paymentData = json_decode(app($paymentMethod->options->init)->init(new Request($dataResponse))->content())->data;
      $dataResponse = array_merge($dataResponse, collect($paymentData)->toArray());
    }
    
    
    //if (isset($paymentMethod->id))
      // Event To create OrderItems, OrderOptions, next send email
      try {
        event(new OrderWasCreated($order, $orderData['orderItems']));
        
      } catch (\Exception $e) {
        \Log::error("error: " . $e->getMessage() . "\n" . $e->getFile() . "\n" . $e->getLine() . $e->getTraceAsString());
      }
    
    //update cart status
    $updateCart = $this->cart->update($cart, ['status' => 2]);
    
    //Response
    $response = $dataResponse;
    \DB::commit(); //Commit to Data Base
     } catch (\Exception $e) {
       \DB::rollback();//Rollback to Data Base
       $response = ["errors" => $e->getMessage()];
     }
    
    //Return response
    return $response;
  }
}
