<?php

namespace Modules\Icommerce\Support;

// Entities
use Modules\Icommerce\Entities\Coupon as CouponEntity;
use Modules\Icommerce\Entities\Cart;
use Modules\Icommerce\Entities\CouponOrderHistory;
use Modules\Icommerce\Entities\Category;

class Coupon
{
  /**
   * Get the discount that applies to the car according to the coupon provided
   * @param $coupon
   * @param $cart
   * @return $discount
   */
  public function getDiscount ($coupon, $cartId, $storeId=null) {

    // Get Cart data
    $cart = Cart::find( $cartId );

    // Validate if cart exists
    if ( $cart == null ){
      return $this->setResponseMessages(trans('icommerce::coupons.messages.cart not exists'));
    }
 
    // Validate if cart has items
    if ( count($cart->products ) < 1){
      return $this->setResponseMessages(trans('icommerce::coupons.messages.cart without items'));
    }
    //\Log::info("cart validation: if cart has items");

    // Coupon for order (1 coupon for all items of the order)
    if ( $coupon->type == 1 ){
      $discount = $this->calcDiscount($coupon->type_discount, $coupon->discount, $cart->total);
      return $this->setResponseMessages(trans('icommerce::coupons.messages.coupon whit discount for order'), $discount, 1);
    }else{

     
      $total = $this->calcTotal($coupon, $cart);

        if($total>0){

          $discount = $this->calcDiscount($coupon->type_discount, $coupon->discount, $total);

          return $this->setResponseMessages(trans('icommerce::coupons.messages.coupon apply'), $discount, 1);
        }else{
           return $this->setResponseMessages(trans('icommerce::coupons.messages.coupon not apply product'), 0, 0);
        }
        
    }

    // Default response
    return $this->setResponseMessages();
  }

   /**
   * Get All Categories
   * @param $categories
   * @return $allCategories from coupon
   */
  private function getAllCategories($categories){

    $allCategories = collect([]);
    foreach ($categories as $key => $category) {
      $descendants = Category::descendantsAndSelf($category->id);
      $allCategories = $allCategories->merge($descendants);
    }

    return $allCategories;
  }

  /**
   * Calc total
   * @param $coupon
   * @param $cart
   * @param $type
   * @return $total
   */
  private function calcTotal ( $coupon, $cart ) {
   
    $total = 0;

    if($coupon->categories->isNotEmpty()){
      $couponCategories = $this->getAllCategories($coupon->categories);
      $couponIdsCategories = $couponCategories->pluck('id')->toArray();
    }

    if($coupon->manufacturers->isNotEmpty())
      $couponIdsManufacturers = $coupon->manufacturers->pluck('id')->toArray();
    

    if($coupon->products->isNotEmpty())
      $couponIdsProducts = $coupon->products->pluck('id')->toArray();
    
    $productsIds = [];

    foreach ($cart->products as $cartProduct){
      
      // Validations to Categories
      if($coupon->categories->isNotEmpty()){
        $productIdsCategories = $cartProduct->product->categories->pluck('id')->toArray();
        $intersections = array_intersect($couponIdsCategories, $productIdsCategories);

        if(!empty($intersections)){
          array_push($productsIds, $cartProduct->id);
          $total += $cartProduct->total;
        }
      }

       // Validations to Manufacturers
      if($coupon->manufacturers->isNotEmpty()){

        $productIdManufacturer = $cartProduct->product->manufacturer->id;

        if(in_array($productIdManufacturer,$couponIdsManufacturers) && !in_array($cartProduct->id, $productsIds)){
           array_push($productsIds, $cartProduct->id);
           $total += $cartProduct->total;
        }

      }

       // Validations to Product
      if($coupon->products->isNotEmpty()){

        if(in_array($cartProduct->product->id,$couponIdsProducts) && !in_array($cartProduct->id, $productsIds)){
           array_push($productsIds, $cartProduct->id);
           $total += $cartProduct->total;
        }

      }
     
    }
    return $total;
  }

  /**
   * Calc total
   * @param $typeDiscount
   * @param $value
   * @param $total
   * @return $discount
   */
  private function calcDiscount ( $typeDiscount, $value, $total ) {
    // 0 = Fix value
    if ( $typeDiscount == 0 ){
      return $value;
    }
    // 0 = percentage
    if ( $typeDiscount == 1 ){
      return $total * $value / 100;
    }
    // Default return
    return 0;
  }

  /**
   * Calc total
   * @param $message
   * @param $discount
   * @return []
   */
  private function setResponseMessages ( $message = 'Error', $discount = 0, $status = 0) {
    return (object)[
      'status' => $status,
      'message' => $message,
      'discount' => $discount
    ];
  }

  /**
   * redeem Coupon
   * @param $couponId
   * @param $orderId
   * @param $customerId
   * @param $amount
   * @return $coupon
   */
  public function  redeemCoupon ($couponId, $orderId, $customerId, $amount) {
    $coupon = CouponOrderHistory::create([
      'coupon_id' => $couponId,
      'order_id' => $orderId,
      'customer_id' => $customerId,
      'amount' => $amount,
    ]);
    return $coupon;
  }

  /**
   * get CouponBy Code
   * @param
   * @return
   */
  public function getCouponByCode ($code) {
    return CouponEntity::where( 'code', $code )->first();
  }

}
