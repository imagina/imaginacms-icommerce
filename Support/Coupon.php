<?php

namespace Modules\Icommerce\Support;

// Entities
use Modules\Icommerce\Entities\Cart;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Entities\Coupon as CouponEntity;
use Modules\Icommerce\Entities\CouponOrderHistory;

class Coupon
{
    /**
     * Get the discount that applies to the car according to the coupon provided
     *
     * @param $cart
     * @return $discount
     */
    public function getDiscount($coupon, $cartId, $storeId = null)
    {
        // Get Cart data
        $cart = Cart::find($cartId);

        // Validate if cart exists
        if ($cart == null) {
            return $this->setResponseMessages(trans('icommerce::coupons.messages.cart not exists'));
        }

        // Validate if cart has items
        if (count($cart->products) < 1) {
            return $this->setResponseMessages(trans('icommerce::coupons.messages.cart without items'));
        }
        //\Log::info("cart validation: if cart has items");

        // Coupon for order (1 coupon for all items of the order)
        if ($coupon->type == 1) {
            //\Log::info("COUPON - ALL ITEMS");

            $discount = $this->calcDiscount($coupon->type_discount, $coupon->discount, $cart->total);

            $allDiscounts = $this->getDiscountByProducts($cart, $discount);

            return $this->setResponseMessages(trans('icommerce::coupons.messages.coupon whit discount for order'), $discount, 1, $allDiscounts);
        } else {
            //\Log::info("COUPON - CHECK OTHERS VALIDATIONS");

            $result = $this->calcTotal($coupon, $cart);
            $total = $result['total'];

            if ($total > 0) {
                $discount = $this->calcDiscount($coupon->type_discount, $coupon->discount, $total);

                return $this->setResponseMessages(trans('icommerce::coupons.messages.coupon apply'), $discount, 1, $result['discounts']);
            } else {
                return $this->setResponseMessages(trans('icommerce::coupons.messages.coupon not apply product'), 0, 0);
            }
        }

        // Default response
        return $this->setResponseMessages();
    }

    /**
     * Get All Categories
     *
     * @return $allCategories from coupon
     */
    private function getAllCategories($categories)
    {
        $allCategories = collect([]);
        foreach ($categories as $key => $category) {
            $descendants = Category::descendantsAndSelf($category->id);
            $allCategories = $allCategories->merge($descendants);
        }

        return $allCategories;
    }

    /**
     * Calc total
     *
     * @param $type
     * @return $total
     */
    private function calcTotal($coupon, $cart)
    {
        $total = 0;

        //\Log::info("COUPON - CALC TOTAL");

        if ($coupon->categories->isNotEmpty()) {
            $couponCategories = $this->getAllCategories($coupon->categories);
            $couponIdsCategories = $couponCategories->pluck('id')->toArray();
        }

        if ($coupon->manufacturers->isNotEmpty()) {
            $couponIdsManufacturers = $coupon->manufacturers->pluck('id')->toArray();
        }

        if ($coupon->products->isNotEmpty()) {
            $couponIdsProducts = $coupon->products->pluck('id')->toArray();
        }

        $productsIds = [];

        $discounts = [];
        $i = 0;

        foreach ($cart->products as $cartProduct) {
            //\Log::info("------ CHECK CART PRODUCT ------");

            // Validations to Categories
            if ($coupon->categories->isNotEmpty()) {
                //\Log::info("COUPON CATEGORIES");
                $productIdsCategories = $cartProduct->product->categories->pluck('id')->toArray();
                $intersections = array_intersect($couponIdsCategories, $productIdsCategories);

                if (! empty($intersections)) {
                    array_push($productsIds, $cartProduct->id);

                    //\Log::info("COUPON - TOTAL CART PRODUCT:".$cartProduct->total);

                    $discounts[$i] = $this->applyDiscount($coupon, $cartProduct);
                    $i++;

                    $total += $cartProduct->total;
                }
            }

            // Validations to Manufacturers
            if ($coupon->manufacturers->isNotEmpty()) {
                //\Log::info("COUPON MANUFACTURERS");
                $productIdManufacturer = $cartProduct->product->manufacturer->id;

                if (in_array($productIdManufacturer, $couponIdsManufacturers) && ! in_array($cartProduct->id, $productsIds)) {
                    array_push($productsIds, $cartProduct->id);

                    //\Log::info("COUPON - TOTAL CART PRODUCT:".$cartProduct->total);

                    $discounts[$i] = $this->applyDiscount($coupon, $cartProduct);
                    $i++;

                    $total += $cartProduct->total;
                }
            }

            // Validations to Product
            if ($coupon->products->isNotEmpty()) {
                //\Log::info("COUPON PRODUCTS");
                if (in_array($cartProduct->product->id, $couponIdsProducts) && ! in_array($cartProduct->id, $productsIds)) {
                    array_push($productsIds, $cartProduct->id);

                    //\Log::info("COUPON - TOTAL CART PRODUCT:".$cartProduct->total);

                    $discounts[$i] = $this->applyDiscount($coupon, $cartProduct);
                    $i++;

                    $total += $cartProduct->total;
                }
            }
        }

        $result['total'] = $total;
        $result['discounts'] = $discounts;

        return $result;
        //return $total;
    }

    /**
     * Calc total
     *
     * @return $discount
     */
    private function calcDiscount($typeDiscount, $value, $total)
    {
        //\Log::info("COUPON - CALC DISCOUNT - TOTAL: ".$total);

        // 0 = Fix value
        if ($typeDiscount == 0) {
            return $value;
        }
        // 0 = percentage
        if ($typeDiscount == 1) {
            return $total * $value / 100;
        }
        // Default return
        return 0;
    }

    /**
     * Calc total
     *
     * @return []
     */
    private function setResponseMessages($message = 'Error', $discount = 0, $status = 0, $allDiscounts = null)
    {
        return (object) [
            'status' => $status,
            'message' => $message,
            'discount' => $discount,
            'allDiscounts' => $allDiscounts,
        ];
    }

    /**
     * redeem Coupon
     *
     * @return $coupon
     */
    public function redeemCoupon($couponId, $orderId, $customerId, $amount)
    {
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
     */
    public function getCouponByCode($code)
    {
        return CouponEntity::where('code', $code)->first();
    }

    /**
     * Apply Discount
     *
     * @return array (Product Id , Discount)
     */
    public function applyDiscount($coupon, $cartProduct)
    {
        $discount = $this->calcDiscount($coupon->type_discount, $coupon->discount, $cartProduct->total);

        $discountProduct = [
            'productId' => $cartProduct->product->id,
            'discount' => $discount,
        ];

        return $discountProduct;
    }

    /**
     * Get Discount By Product Just Case $coupon->type = 1 (all items of the order) needed to Taxes
     *
     * @return array (Product Id , Discount)
     */
    public function getDiscountByProducts($cart, $totalDiscount)
    {
        $discounts = [];

        $discountByProduct = $totalDiscount / $cart->products->count();

        foreach ($cart->products as $cartProduct) {
            $discountProduct = [
                'productId' => $cartProduct->product->id,
                'discount' => $discountByProduct,
            ];

            array_push($discounts, $discountProduct);
        }

        return $discounts;
    }
}
