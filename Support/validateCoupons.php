<?php

namespace Modules\Icommerce\Support;

// Entities
use Modules\Icommerce\Entities\Coupon;
use Modules\Icommerce\Entities\Cart;
use Modules\Icommerce\Entities\CouponOrderHistory;

class validateCoupons
{
  /**
   * Get the discount that applies to the car according to the coupon provided
   * @param $couponCode
   * @param $cart
   * @return $discount
   */
  public function validateCode ($couponCode, $cartId,$storeId) {

    // Get coupon
    $coupon = Coupon::where( 'code', $couponCode)->where('store_id',$storeId)->orWhere('store_id',null)->first();

    // Validate if code exists on DB table coupons
    if ( $coupon == null ){
      return $this->setResponseMessages(trans('icommerce::coupons.messages.coupon not exist'));
    }

    // Validate if coupon active (0 is ID for inactive coupons)
    if ( $coupon->status == 0 ){
      return $this->setResponseMessages(trans('icommerce::coupons.messages.coupon inactive'));
    }

    // validate if the coupon is valid (Dates)
    $now = date('Y-m-d');
    if ( !( $now >= $coupon->date_start ) ){
      return $this->setResponseMessages(trans('icommerce::coupons.messages.coupon not started'));
    }
    if ( !( $now <= $coupon->date_end ) ){
      return $this->setResponseMessages(trans('icommerce::coupons.messages.coupon expired'));
    }

    // Validate the number of times the coupon has been used
    if($coupon->quantity_total>0){//If quantity total == 0 is infinite
      if ( $coupon->usesTotal >= $coupon->quantity_total ){
        return $this->setResponseMessages(trans('icommerce::coupons.messages.maximum used coupons'));
      }
    }

    // Validate the number of times the coupon has been used by the logged in user
    if($coupon->quantity_total_customer>0){
      if ( $coupon->usesTotalPerUser >= $coupon->quantity_total_customer ){
        return $this->setResponseMessages(trans('icommerce::coupons.messages.maximum coupons per user used'));
      }
    }

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

    // Coupon for order (1 coupon for all items of the order)
    if ( $coupon->type == 1 ){
      $discount = $this->calcDiscount($coupon->type_discount, $coupon->discount, $cart->total);
      return $this->setResponseMessages(trans('icommerce::coupons.messages.coupon whit discount for order'), $discount, 1);
    }

    // Coupon for product (2: coupon for specific product)
    if ( $coupon->type == 2 && $coupon->product_id ){
      $total = $this->calcTotal($coupon, $cart, 'product');
      $discount = $this->calcDiscount($coupon->type_discount, $coupon->discount, $total);
      return $this->setResponseMessages(trans('icommerce::coupons.messages.coupon whit discount for product'), $discount, 1);
    }

    // Coupon for category (3: coupon for product in a category specific)
    if ( $coupon->type == 3 && $coupon->category_id ){
      $total = $this->calcTotal($coupon, $cart, 'category');
      $discount = $this->calcDiscount($coupon->type_discount, $coupon->discount, $total);
      return $this->setResponseMessages(trans('icommerce::coupons.messages.coupon whit discount for category'), $discount, 1);
    }

    // Default response
    return $this->setResponseMessages();
  }

  /**
   * Calc total
   * @param $coupon
   * @param $cart
   * @param $type
   * @return $total
   */
  private function calcTotal ( $coupon, $cart, $type ) {
    $total = 0;
    foreach ($cart->products as $product){
      if ( $product->product_id == $coupon->product_id && $type == 'product' ){
        $total += $product->total;
      }
      if ( $product->product->category_id == $coupon->category_id && $type == 'category' ){
        $total += $product->total;
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
    return Coupon::where( 'code', $code )->first();
  }

}
