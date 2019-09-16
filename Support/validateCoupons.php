<?php

namespace Modules\Icommerce\Support;

// Entities
use Modules\Icommerce\Entities\Coupon;
use Modules\Icommerce\Entities\Cart;

class validateCoupons
{
  /**
   * Get the discount that applies to the car according to the coupon provided
   * @param $couponCode
   * @param $cart
   * @return $discount
   */
  public function validateCode ( $couponCode, $cartId ) {

    // Get coupon
    $coupon = Coupon::where( 'code', $couponCode )->first();

    // Validate if code exists on DB table coupons
    if ( $coupon == null ){
      return $this->setResponseMessages('coupon not exists' );
    }

    // Validate if coupon active (0 is ID for inactive coupons)
    if ( $coupon->status == 0 ){
      return $this->setResponseMessages('coupon inactive' );
    }

    // validate if the coupon is valid (Dates)
    $now = date('Y-m-d');
    if ( !( $now >= $coupon->date_start ) ){
      return $this->setResponseMessages('coupon no started');
    }
    if ( !( $now <= $coupon->date_end ) ){
      return $this->setResponseMessages('coupon expired');
    }

    // Validate the number of times the coupon has been used
    if ( $coupon->usesTotal >= $coupon->quantity_total ){
      return $this->setResponseMessages('maximum used coupons');
    }

    // Validate the number of times the coupon has been used by the logged in user
    if ( $coupon->usesTotalPerUser >= $coupon->quantity_total_customer ){
      return $this->setResponseMessages('maximum coupons per user used');
    }

    // Get Cart data
    $cart = Cart::find( $cartId );

    // Validate if cart exists
    if ( $cart == null ){
      return $this->setResponseMessages('cart not exists');
    }

    // Validate if cart has items
    if ( count($cart->products ) < 1){
      return $this->setResponseMessages('cart without items');
    }

    // Coupon for order (1 coupon for all items of the order)
    if ( $coupon->type == 1 ){
      $discount = $this->calcDiscount($coupon->type_discount, $coupon->discount, $cart->total);
      return $this->setResponseMessages('coupon whit discount for order', $discount);
    }

    // Coupon for product (2: coupon for specific product)
    if ( $coupon->type == 2 && $coupon->product_id ){
      $total = $this->calcTotal($coupon, $cart, 'product');
      $discount = $this->calcDiscount($coupon->type_discount, $coupon->discount, $total);
      return $this->setResponseMessages('coupon whit discount for product', $discount);
    }

    // Coupon for category (3: coupon for product in a category specific)
    if ( $coupon->type == 3 && $coupon->category_id ){
      $total = $this->calcTotal($coupon, $cart, 'category');
      $discount = $this->calcDiscount($coupon->type_discount, $coupon->discount, $total);
      return $this->setResponseMessages('coupon whit discount for category', $discount);
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
  private function setResponseMessages ( $message = 'Error', $discount = 0 ) {
    return [
      'message' => $message,
      'discount' => $discount
    ];
  }
}
