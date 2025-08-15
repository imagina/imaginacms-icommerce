<?php


namespace Modules\Icommerce\Services;

use Modules\Icommerce\Entities\Cart;
use Modules\Icommerce\Events\OrderWasCreated;
use Modules\Icommerce\Repositories\CartRepository;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Support\OrderHistory as orderHistorySupport;
use Modules\Icommerce\Support\OrderItem as orderItemSupport;
use Modules\Icommerce\Support\Coupon as validateCoupons;
use Modules\Iprofile\Repositories\UserApiRepository;
use Modules\Icommerce\Repositories\CartProductRepository;
use Illuminate\Http\Request;

class CartService
{

  private $orderRepository;
  private $log = "Icommerce::CartService||";

  public function __construct(

    CartRepository $cart,
    CartProductRepository $cartProduct,
    UserApiRepository $user
  )
  {
    $this->cart = $cart;
    $this->cartProduct = $cartProduct;
    $this->user = $user;
    $this->orderRepository = app("Modules\Icommerce\Repositories\OrderRepository");
  }

  /**
   * CREATE A ITEM
   *
   * @param Request $request
   * @return mixed
   */
  public function create($data)
  {

    $needTobeCreated = true;
    if (isset($data['cartId']) || isset($data['cart_id'])) {
      $cart = $this->cart->find($data['cartId'] ?? $data['cart_id']);
      $needTobeCreated = false;
    } elseif (isset($data['cart']->id)) {
      $cart = $data['cart'];
      $needTobeCreated = false;
      if(!isset($cart->id)){
        $needTobeCreated = true;
      }
    }elseif(isset($data['userId'])){
      $cart = $this->cart->getItem($data['userId'],json_decode(json_encode(["filter" => ["field" => "user_id","status" => 1]])));
      $needTobeCreated = false;
    }

    if($needTobeCreated){

      $userId = \Auth::id();

      if(!empty($userId)){
        Cart::where("user_id",$userId)->where("status",1)->delete();
      }

      $cartData = [
        "ip" => request()->ip(),
        "session_id" => session('_token'),
	      "status" => 1,
        "user_id" => $data["userId"] ?? $data["customerId"] ?? \Auth::id()
      ];

      //Create cart
      $cart = $this->cart->create($cartData);

      if(isset($data["products"])){
        $products = !is_array($data["products"]) ? [$data["products"]] : $data["products"];
        //Creating Products in the cart
        foreach ($products as $product) {

          $cartProductData = [
            "cart_id" => $cart->id,
            "product_id" => $product["id"],
            "quantity" => $product["quantity"],
            "options" => $product["options"] ?? null,
            "product_option_values" => $product["productOptionValues"] ?? []
          ];

          //Create cart item
          $this->cartProduct->create($cartProductData);
        }
      }

      request()->session()->put('cart', $cart);

    }
    return $cart;
  }

  public function totalTaxes($data = null){

   $cart = $this->create($data);

   $couponDiscounts = collect($data["couponDiscounts"])->keyBy("productId");

   $taxes = [];
   foreach ($cart->products as $cartProduct) {

     array_push($taxes,$cartProduct->product->tax($couponDiscounts[$cartProduct->product->id]["discount"] ?? 0));
   }

   return $taxes;
  }

  /**
   * create a cart from Order Id
   */
  public function createCartFromOrder($orderId)
  {

    \Log::info($this->log."createCartFromOrder");

    $userId = \Auth::id() ?? null;
    \Log::info($this->log."createCartFromOrder|UserId: ".$userId);

    //Validation Order
    $order = $this->orderRepository->getItem($orderId);
    if(is_null($order)) return null;

    //Validation Cart Old
    $cartOrder = $this->cart->getItem($order->cart_id);
    if(is_null($cartOrder)) return null;
    //\Log::info($this->log."createCartFromOrder|CartOrder: ".$cartOrder->id);

    //If there were to be a cart in session
    $cartSession = request()->session()->get('cart');
    if(!is_null($cartSession)){
      $cartSession = json_decode($cartSession);
      //\Log::info($this->log."createCartFromOrder|Exist in session cartId: ".$cartSession->id);

      $cartSessionData = $this->cart->getItem($cartSession->id);
      if($cartSessionData) $this->cart->update($cartSessionData, ['status' => 2]);
      request()->session()->forget('cart');

    }

    //Create new cart
    $dataNewCart = [
        "ip" => request()->ip(),
        "session_id" => session('_token'),
        "status" => 1,
        "user_id" => $userId,
        "forceCreate" => true
    ];
    $cart = $this->cart->create($dataNewCart);
    \Log::info($this->log."createCartFromOrder|New CartId: ".$cart->id);

    //Extra validations in new cart | Created cart can be a previous one with products
    if($cart->products()->count() > 0){
      foreach ($cart->products as $cartProduct2) {
        $cartProduct2->delete();
      }
    }

    $errorMsjs = [];

    //Process Products from Old cart in new cart
    foreach ($cartOrder->products as $cartProduct)
    {
      \Log::info($this->log."createCartFromOrder|CreateCartProduct|ProductId: ".$cartProduct->product_id);
      try {
        $cartProductData = [
          "cart_id" => $cart->id,
          "product_id" => $cartProduct->product_id,
          "quantity" => $cartProduct->quantity,
          "product_option_values" => $cartProduct->productOptionValues->pluck('id')->toArray() ?? []
        ];

        $this->cartProduct->create($cartProductData);

      } catch (\Exception $e) {
        \Log::info($this->log."Error: ".$e->getMessage());
        $errorMsjs[] = ['msjs' =>  $e->getMessage(), 'productId' => $cartProduct->product_id, 'productName' => $cartProduct->product->name];
      }

    }

    //Set sessions vars
    request()->session()->put('cart', json_encode($cart));
    if(!empty($errorMsjs))
      request()->session()->put('warningProductsDeleted', json_encode($errorMsjs));

    //Result
    return $cart;

  }

}
