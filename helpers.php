<?php

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Entities\Order;
use Modules\Icommerce\Entities\Order_History;
use Modules\Icommerce\Entities\Order_Product;
use Modules\Icommerce\Entities\Order_Status;
use Modules\Icommerce\Entities\Payment;
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Entities\Product_Discount;
use Modules\Icommerce\Entities\Status;
use Modules\Icommerce\Entities\Currency;

/**
 * Get Status Enabled / Disabled
 *
 * @param  none
 * @return Array $status
 */
if (!function_exists('icommerce_get_status')) {

    function icommerce_get_status()
    {
        $status = new Status();
        return $status;
    }
}

/**
 * get Enabled Shipping Methods
 *
 * @param  none
 * @return $resultMethods 0 or Collection
 */
if (!function_exists('icommerce_get_shippingMethods')) {

    function icommerce_get_shippingMethods()
    {

        $shippingMethods = config('asgard.icommerce.config.shippingmethods');
        $fixCollect = collect([]);
        $resultMethods = collect([]);

        if (isset($shippingMethods) && count($shippingMethods) > 0) {
            foreach ($shippingMethods as $key => $method) {

                $methodConfiguration = null;
                try {
                    $methodConfiguration = $method['entity']::query()->first();
                } catch (\Exception $e) {
                    $methodConfiguration = null;
                }

                if ($methodConfiguration != null && $methodConfiguration->status == 1) {
                    $methodConfiguration->configName = $method['name'];
                    $methodConfiguration->configTitle = $method['title'];
                    $resultMethods->push($methodConfiguration);
                }
            }
        }

        if (count($shippingMethods) == 0 || ($resultMethods->count()) == 0)
            $resultMethods = null;

        return $resultMethods;

    }

}

/**
 * Format date
 *
 * @param date
 * @return date
 */
if (!function_exists('icommerce_formatDate')) {

    function icommerce_formatDate($date, $format = "d-m-Y H:m:s")
    {
        $d = Carbon::parse($date);
        return $d->format($format);
    }

}

/**
 * After The Payment Method
 *
 * @param orderID,status,request
 * @return
 */
if (!function_exists('icommerce_executePostOrder')) {

    function icommerce_executePostOrder($orderID, $status, $request)
    {


        // Actualizar Status de la Orden (order_status)
        // Crear un Order History
        // Actualizar status Payment
        // Si hubo cupon Actualizar el Coupon History y la Cantidad en Cupon

        // si el pago es aprobado se decuenta del stock en la BD segun el precio
        if ($status == 1) {
            Order::where("id", $orderID)->update(['order_status' => 12]);
            Payment::where("order_id", $orderID)->update(['status' => 12]);
            Order_History::create(['order_id' => $orderID, 'status' => 12, 'notify' => 1]);
            $products = Order_Product::where("order_id", $orderID)->get();

            foreach ($products as $product) {
                $qtyStockProduct = Product::find($product->product_id)->quantity;
                $priceProduct = Product::find($product->product_id)->price;


                // validacion por el Precio para descontar del Stock de Producto o Producto Descuento
                if ($product->price == $priceProduct) {
                    $qtyStockProduct -= $product->quantity;
                    Product::find($product->product_id)->update(['quantity' => $qtyStockProduct]);
                } else {
                    $qtyStockProdDiscount = Product_Discount::where('product_id', $product->product_id)->get()->quantity;
                    $priceProdDiscount = Product_Discount::where('product_id', $product->product_id)->get()->price;
                    $qtyStockProdDiscount -= $product->quantity;
                    Product_Discount::where('product_id', $product->product_id)->get()->update(['quantity' => $qtyStockProdDiscount]);
                }
            }
        } else {
            Order::where("id", $orderID)->first()->update(['order_status' => $status]);
            Payment::where("order_id", $orderID)->first()->update(['status' => $status]);
            Order_History::create(['order_id' => $orderID, 'status' => $status, 'notify' => 1]);
        }

        /*
        // Descuento el Cupon (si hubo error en la plataforma)
        if($status==0 || $status==4 ){

            if($request->session()->exists('couponID')) {
                    $couponID = session('couponID');
                    $deleteOrderCoupon = OrderCoupon::where('order_id',$orderID)
                    ->where('coupon_id',$couponID)
                    ->delete();
                    $coupon = Coupon::find($couponID);

                    // Actualizo cant del cupon
                    $coupon->cant = $coupon->cant + 1;
                    $coupon->save();
                           
            }
        }
    */
        //Log::info('Sesion: '.session('orderID'));

        //Cache::flush();

        return $orderID;

    }

}

/**
 * Send Email
 *
 * @param options array
 * @return response Email
 */
if (!function_exists('icommerce_emailSend')) {

    function icommerce_emailSend($options = array())
    {
        $default_options = array(
            'email_from' => array(),
            'theme' => null,
            'email_to' => array(),
            'subject' => null,
            'sender' => null,
            'data' => array(
                'title' => null,
                'intro' => null,
                'content' => array(),
            ),
        );

        $options = array_merge($default_options, $options);
        $response = array();
        try {
            $data = $options['data'];

            /**
             * Send email
             */

            $email_to = $options['email_to'];
            $email_from = $options['email_from'];

            $sender = $options['sender'];
            $subject = $options['subject'];

            Mail::send($options['theme'],
                [
                    'data' => $data,
                ], function ($message) use ($email_to, $sender, $subject, $email_from) {
                    $message->to($email_to, $sender)
                        ->from($email_from, $sender)
                        ->subject($subject);
                });
            $response['status'] = 'success';
            $response['msg'] = '';

        } catch (\Throwable $t) {

            $response['status'] = 'error';
            $response['msg'] = $t->getMessage();
        }

        return $response;


    }
}

/**
 * Get Category Product
 * @param options array
 * @return object
 */

if (!function_exists('get_product_category')) {
    function get_product_category($options = array())
    {

        $default_options = array(
            'include' => array(),//id de Categorias  para incluir en una consulta, se envia como arreglo ['include'=>[1,2,3]]
            'exclude' => array(),//id de categorias  que desee excluir de una consulta metodo de llmado category=>'[1,2]'
            'parent' => [0], //id de categorias  padre que desee mostrar en una consulta metodo de llmado category=>'[1,2]'
            'take' => 5, //Numero de posts a obtener,
            'skip' => 0, //Omitir Cuantos post a llamar
            'order' => 'desc',//orden de llamado
        );

        $options = array_merge($default_options, $options);

        $categories = Category::query();
        if (!empty($options['include'])) {
            $categories->whereIn('id', $options['include']);
        }
        if (!empty($options['exclude'])) {
            $categories->whereNotIn('id', $options['exclude']);
        }
        if (!empty($options['parent'])) {
            $categories->whereIn('parent_id', $options['parent']);
        }
        if ($options['take'] !== -1) {
            $categories->take($options['take']);
        }
        if ($options['skip'] > 0) {
            $categories->skip($options['skip']);
        }
        $categories->orderBy('slug', $options['order']);

        return $categories->get();
    }
}


/**
 * Get Order Status Enabled / Disabled
 *
 * @param  none
 * @return Array $status
 */
if (!function_exists('icommerce_get_Orderstatus')) {

    function icommerce_get_Orderstatus()
    {
        $status = new Order_status();
        return $status;
    }
}


/**
 * Get Gallery Product
 *
 * @param  Int id
 * @return Array $images
 */
if (!function_exists('productgallery')) {

    function productgallery($id)
    {
        $images = Storage::disk('publicmedia')->files('assets/icommerce/product/gallery/' . $id);
        return $images;
    }
}


/**
 * Search a text in array texts
 *
 * @param  String name
 * @param  Array names
 * @return Boolean
 */
if (!function_exists('icommerce_strposa')) {

    function icommerce_strposa($name, $works, $offset = 0)
    {

        if (!is_array($works))
            $works = array($works);
        /*
        foreach($works as $query) {
            if(stripos($name, $query, $offset) !== false)
                return true;
        }
        */

        foreach ($works as $work) {
            if ($name == $work)
                return true;
        }

        return false;
    }

}

/**
 * Get Total Dimensions from All Products in the cart
 *
 * @param  Collection $items
 * @return Array $dimensions
 */
if (!function_exists('icommerce_totalDimensions')) {

    function icommerce_totalDimensions($items)
    {

        $tWidth = 0;
        $tHeight = 0;
        $tLength = 0;

        foreach ($items as $key => $item) {

            $tWidth += ($item->width > 0) ? $item->width : 1;
            $tHeight += ($item->height > 0) ? $item->height : 1;
            $tLength += ($item->length > 0) ? $item->length : 1;

        }

        $dimensions = array($tWidth, $tHeight, $tLength);

        return $dimensions;

    }

}

/**
 * Check if all items have freeshipping
 *
 * @param  Collection $items
 * @param  String $countryCode // Destiny
 * @return Boolean
 */

if (!function_exists('icommerce_checkAllItemsFreeshipping')) {

    function icommerce_checkAllItemsFreeshipping($items, $options = array())
    {

        $cant = 0;

        $countryCode = isset($options["countryCode"]) ? $options["countryCode"] : null;

        if (setting('icommerce::country-freeshipping')) {
            $countryFree = setting('icommerce::country-freeshipping');
        } else {
            return false;
        }

        if (!$countryCode) {
            if (setting('icommerce::country-default')) {
                $countryCode = setting('icommerce::country-default');
            } else {
                return false;
            }
        }

        foreach ($items as $key => $item) {

            // The product has freeshipping and Country Destiny is the same that Country freeshipping
            if (isset($item->freeshipping) && !empty($item->freeshipping)) {
                if ($item->freeshipping == 1 && $countryCode == $countryFree)
                    $cant++;
            }
        }

        if ($cant == count($items) && count($items) > 0)
            return true;
        else
            return false;

    }

}

/**
 * Get Total Weight for All items validing freeshipping
 *
 * @param  Collection $items
 * @param  String $countryCode // Destiny
 * @return Float
 */
if (!function_exists('icommerce_getTotalWeight')) {

    function icommerce_getTotalWeight($items, $countryCode, $freeshipping = 0)
    {

        $countryFree = "";

        // If Country freeshipping is Null that's no matter
        // because in the validation the $countryCode!=$countryFree
        // the weight would be added
        if (setting('icommerce::country-freeshipping')) {
            $countryFree = setting('icommerce::country-freeshipping');
        }

        $totalWeight = 0;

        foreach ($items as $key => $item) {
            $weightItem = 0;

            // The product don't have freeshipping = 0
            if ($item->freeshipping == $freeshipping) {
                $weightItem = ($item->weight > 0) ? $item->weight : 1;
                $totalWeight = $totalWeight + ($weightItem * $item->quantity);
            } else {

                // The product has freeshipping
                // and country destiny it's not the freeshipping Country
                if ($item->freeshipping == 1 && $countryCode != $countryFree) {
                    $weightItem = ($item->weight > 0) ? $item->weight : 1;
                    $totalWeight = $totalWeight + ($weightItem * $item->quantity);
                }

            }
        }

        return $totalWeight;
    }

}
if (!function_exists('localesymbol')) {

    function localesymbol($code = 'USD')
    {
        $currency = Currency::where('code', $code)->whereStatus(Status::ENABLED)->first();
        if (!isset($currency)) {
            $currency = (object)[
                'symbol_left' => '$',
                'symbol_right' => '',
                'code'=>'USD',
                'value'=>1
            ];
        }
        return $currency;
    }

}

if (!function_exists('formatMoney')) {

    function formatMoney($value)
    {
        $format =(object) Config::get('asgard.icommerce.config.formatmoney');

        return number_format($value, $format->decimals,$format->dec_point, $format->housands_sep);

    }

}