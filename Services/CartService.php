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
  
  public function __construct(

    CartRepository $cart,
    CartProductRepository $cartProduct,
    UserApiRepository $user
  )
  {
    $this->cart = $cart;
    $this->cartProduct = $cartProduct;
    $this->user = $user;
  }
  
  /**
   * CREATE A ITEM
   *
   * @param Request $request
   * @return mixed
   */
  public function create($data)
  {
    $userId = \Auth::id();
    
    if(!empty($userId)){
      Cart::where("user_id",$userId)->where("status",1)->delete();
    }
    
      $cartData = [
        "ip" => request()->ip(),
        "session_id" => session('_token'),
        "user_id" => $data["userId"] ?? $data["customerId"] ?? \Auth::id()
      ];
      
      //Create cart
      $cart = $this->cart->create($cartData);
  
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
  
      request()->session()->put('cart', $cart);

      return $cart;
    
  }
}
