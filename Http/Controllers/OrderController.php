<?php

namespace Modules\Icommerce\Http\Controllers;

use Modules\Core\Http\Controllers\BasePublicController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Anam\Phpcart\Cart as Carting;
use Modules\Icommerce\Entities\Order;
use Modules\Icommerce\Entities\Order_History;
use Modules\Icommerce\Entities\Order_Product;
use Modules\Icommerce\Entities\Order_Option;
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Entities\Product_Discount;
use Modules\Icommerce\Entities\Payment;
use Modules\User\Contracts\Authentication;
use Modules\Notification\Services\Notification;
use Modules\Icommerce\Repositories\CurrencyRepository;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Transformers\ProductTransformer;
use Modules\Iprofile\Repositories\AddressRepository;
use Modules\Iprofile\Repositories\ProfileRepository;
use Modules\Icommerce\Repositories\PaymentRepository;
use Session;
Use DB;
class OrderController extends BasePublicController
{
  private $cart;
  private $currency;
  protected $auth;
  private $notification;
  private $order;
  private $address;
  private $payments;

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function __construct(
    CurrencyRepository $currency,
    Notification $notification,
    OrderRepository $order,
    ProfileRepository $profile,
    AddressRepository $address,
    PaymentRepository $payments)
  {
    parent::__construct();
    $this->cart = new Carting();
    $this->currency = $currency;
    $this->auth = app(Authentication::class);
    $this->notification = $notification;
    $this->order = $order;
    $this->address = $address;
    $this->profile = $profile;
    $this->payments = $payments;
  }

  public function index()
  {
    $tpl = 'icommerce::frontend.orders.index';
    $ttpl = 'icommerce.orders.index';

    if (view()->exists($ttpl)) $tpl = $ttpl;
    $user = $this->auth->user();
    $orders = $this->order->whereUser($user->id);

    return view($tpl, compact('orders', 'user'));
  }

  /**
   * Show the specified resource.
   * @return Response
   */
  public function show(Request $request)
  {
    $tpl = 'icommerce::frontend.orders.show';
    $ttpl = 'icommerce.orders.show';

    //if (view()->exists($ttpl)) $tpl = $ttpl;
    if (!isset($request->key)) {
      $user = $this->auth->user();
      $order = $this->order->findByUser($request->id, $user->id);
    }else
      $order = $this->order->findByKey($request->id, $request->key);

    $products = [];

    if (isset($order) && !empty($order)) {
      if ($order->shipping_amount>0)
        $subtotal = $order->total - $order->shipping_amount;
      else
        $subtotal = $order->total;
      if ($order->tax_amount)
        $subtotal = $subtotal - $order->tax_amount;

      foreach ($order->products as $product){
        if(count($product->pivot->order_option)>0){
          array_push($products, [
            "title" => $product->title,
            "sku" => $product->sku,
            "quantity" => $product->pivot->quantity,
            "price" => $product->pivot->price,
            "total" => $product->pivot->total,
            "options"=>$product->pivot->order_option
          ]);
        }//
        else{
          array_push($products, [
            "title" => $product->title,
            "sku" => $product->sku,
            "quantity" => $product->pivot->quantity,
            "price" => $product->pivot->price,
            "total" => $product->pivot->total,
          ]);
        }//else
      }//foreach order products
      foreach ($this->payments->getPaymentsMethods() as $payment)
        if($order->payment_method == $payment->configName)
          $order->payment_method = $payment->configTitle;

      return view($tpl, compact('order', 'user', 'products','subtotal'));

    } else
      return redirect()->route('home')->withError(trans('icommerce::orders.order_not_found'));



  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create()
  {
    return view('icommerce::create');
  }

  /**
   * Store a newly created resource in storage.
   * @param  Request $request
   * @return Response
   */
   public function store(Request $request)
   {
     DB::beginTransaction();


     $cart = $this->getItems();
     $currency = $this->currency->getActive();

     $request["ip"] = $request->ip();
     $request["user_agent"] = $request->header('User-Agent');
     $request['order_status'] = 0;
     $request['key'] = substr(md5 (date("Y-m-d H:i:s").$request->ip()),0,20);

     $profile = $this->profile->findByUserId($request->user_id);
     if($request->type_person=='legal'){
       $profile->business=$request->profile_business_name;
       $profile->nit=$request->profile_business_nit;
       $profile->type_person="legal";
       $profile->update();
     }
     if ($request->existingOrNewPaymentAddress == '2') {

       try {
         $this->address->create([
           'profile_id' => $profile->id,
           'firstname' => $request->payment_firstname,
           'lastname' => $request->payment_lastname,
           'company' => $request->payment_company,
           'address_1' => $request->payment_address_1,
           'address_2' => $request->payment_address_2,
           'city' => $request->payment_city,
           'postcode' => $request->payment_postcode,
           'country' => $request->payment_country,
           'zone' => $request->payment_zone,
           'email'=>$request->payment_email,
           'nit'=>$request->payment_nit
         ]);

       } catch (Exception $e) {
         DB::rollBack();
         \Log::info($e->getMessage());
         return redirect()->back()->withError($e->getMessage());
       }
     }
     if ($request->existingOrNewShippingAddress == '2' && $request->sameDeliveryBilling!='on') {
       try {
         $this->address->create([
           'profile_id' => $profile->id,
           'firstname' => $request->shipping_firstname,
           'lastname' => $request->shipping_lastname,
           'company' => $request->shipping_company,
           'address_1' => $request->shipping_address_1,
           'address_2' => $request->shipping_address_2,
           'city' => $request->shipping_city,
           'postcode' => $request->shipping_postcode,
           'country' => $request->shipping_country,
           'zone' => $request->shipping_zone,
         ]);
       } catch (Exception $e) {
         DB::rollBack();
         \Log::info($e->getMessage());
         return redirect()->back()->withError($e->getMessage());
       }
     }

     try {
       $order = Order::create($request->all());
     } catch (Exception $e) {
       DB::rollBack();
       \Log::info($e->getMessage());
       return redirect()->back()->withError($e->getMessage());
     }
     try {
       Order_History::create([
         'order_id' => $order->id,
         'status' => $order->order_status,
         'notify' => 1,
       ]);
     } catch (Exception $e) {
       \Log::info($e->getMessage());
       DB::rollBack();
       return response()->json([
         "status" => "500",
         "message" => trans('icommerce::checkout.alerts.error_order') . $e->getMessage()
       ]);
     }

     try {
       foreach ($cart["items"] as $item) {
         $p=Order_Product::create([
           "order_id" => $order->id,
           "product_id" => $item->id,
           "title" => $item->name,
           "quantity" => $item->quantity,
           "price" => floatval($item->price),
           "total" => floatval($item->quantity) * floatval($item->price),
           "tax" => 0,
           "reward" => 0,
         ]);
         if(count($item->options_selected)>0){
           for($i=0;$i<count($item->options_selected);$i++){
             for($o=0;$o<count($item->options_selected[$i]['option_values']);$o++){
               if(count($item->options_selected[$i]['option_values'][$o]['child_options'])>0){
                 for($z=0;$z<count($item->options_selected[$i]['option_values'][$o]['child_options']);$z++){
                   Order_Option::create([
                     "order_id" => $order->id,
                     "order_product_id"=>$p->id,
                     'name'=>$item->options_selected[$i]['description'],
                     'value'=>$item->options_selected[$i]['option_values'][$o]['description'],
                     'type'=>$item->options_selected[$i]['type'],
                     'child_option_name'=>$item->options_selected[$i]['option_values'][$o]['child_options'][$z]['option_description'],
                     'child_option_value'=>$item->options_selected[$i]['option_values'][$o]['child_options'][$z]['description']
                   ]);
                 }//for child options
               }else {
                 Order_Option::create([
                   "order_id" => $order->id,
                   "order_product_id"=>$p->id,
                   'name'=>$item->options_selected[$i]['description'],
                   'value'=>$item->options_selected[$i]['option_values'][$o]['description'],
                   'type'=>$item->options_selected[$i]['type']
                 ]);
               }//else
             }//for option values
           }//for options selected
         }
       }
     } catch (Exception $e) {
       \Log::info($e->getMessage());
       DB::rollBack();
       return response()->json([
         "status" => "500",
         "message" => trans('icommerce::checkout.alerts.error_order') . $e->getMessage()
       ]);
     }

     try {
       foreach ($cart["items"] as $item) {
         Payment::create([
           "order_id" => $order->id,
           "name" => $order->payment_method,
           "amount" => $order->total,
           "status" => $order->order_status,
         ]);
       }
     } catch (Exception $e) {
       \Log::info($e->getMessage());
       DB::rollBack();
       return response()->json([
         "status" => "500",
         "message" => trans('icommerce::checkout.alerts.error_order') . $e->getMessage()
       ]);
     }

     //$this->notification->push('New Order', 'New generated order!', 'fa fa-check-square-o text-green', route('admin.icommerce.order.index'));
     try{
         Session::put('orderID', $order->id);
         $this->cart->clear();
         $paymentMethods = config('asgard.icommerce.config.paymentmethods');
         foreach ($paymentMethods as $paymentMethod)
             if($paymentMethod['name']==$request->payment_method)
                 $urlPayment = route($paymentMethod['name']);
         DB::commit();
         return response()->json([
             "status" => "202",
             "message" => trans('icommerce::checkout.alerts.order_created'),
             "url" => $urlPayment,
             "session" => session('orderID')
         ]);
     }catch (\Exception $e){
         \Log::info($e->getMessage());
         DB::rollBack();
         return response()->json([
             "status" => "500",
             "message" => trans('icommerce::checkout.alerts.error_order') . $e->getMessage()
         ]);
     }

   }

  /**
   * Show the form for editing the specified resource.
   * @return Response
   */
  public function edit()
  {
    return view('icommerce::edit');
  }

  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request)
  {
  }

  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function destroy()
  {
  }

  public function getItems()
  {
    $items = $this->cart->getItems();
    $weight = 0;

    foreach ($items as $index => $item) {
      $item->weight ? $weight += $item->weight : false;
    }

    return [
      'items' => $items,
      'quantity' => $this->cart->totalQuantity(),
      'total' => number_format($this->cart->getTotal(), 2),
      'weight' => $weight
    ];
  }

  public function email()
  {
    $order = $this->order->find(10);
    $products = [];
    foreach ($order->products as $product) {
      if(count($product->pivot->order_option)>0){
        array_push($products, [
          "title" => $product->title,
          "sku" => $product->sku,
          "quantity" => $product->pivot->quantity,
          "price" => $product->pivot->price,
          "total" => $product->pivot->total,
          "options"=>$product->pivot->order_option
        ]);
      }//
      else{
        array_push($products, [
          "title" => $product->title,
          "sku" => $product->sku,
          "quantity" => $product->pivot->quantity,
          "price" => $product->pivot->price,
          "total" => $product->pivot->total,
        ]);
      }
    }
    $userEmail = $order->email;
    $userFirstname = "{$order->first_name} {$order->last_name}";


    $content = [
      'order' => $order,
      'products' => $products,
      'user' => $userFirstname
    ];

    $data = array(
      'title' => null,
      'intro' => null,
      'content' => $content,

    );
    return view("icommerce::email.success_order", compact('data'));
  }

  public function showorder(Request $request)
  {

    $tpl = 'icommerce::frontend.orders.show';

    $orderId = $request->input('id');
    $key = $request->input('key');
    $order = $this->order->find($orderId);
    if (isset($order)) {
      if ($key == $order->key) {
        $shippingMethods = config('asgard.icommerce.config.shippingmethods');
        $paymentMethods = config('asgard.icommerce.config.paymentmethods');
        foreach ($shippingMethods as $key => $method)
          if ($method["name"] == $order->shipping_method)
            $shippingMethodTitle = $method["title"];
        foreach ($paymentMethods as $key => $method)
          if ($method["name"] == $order->payment_method)
            $paymentMethodTitle = $method["title"];

        $products = [];
        if (!empty($order)) {
          foreach ($order->products as $product) {
            if(count($product->pivot->order_option)>0){
              array_push($products, [
                "title" => $product->title,
                "sku" => $product->sku,
                "quantity" => $product->pivot->quantity,
                "price" => $product->pivot->price,
                "total" => $product->pivot->total,
                "options"=>$product->pivot->order_option
              ]);
            }//
            else{
              array_push($products, [
                "title" => $product->title,
                "sku" => $product->sku,
                "quantity" => $product->pivot->quantity,
                "price" => $product->pivot->price,
                "total" => $product->pivot->total,
              ]);
            }//else
          }//foreach order products
        }
        $products = json_encode($products);
        return view($tpl, compact('order', 'products', 'shippingMethodTitle', 'paymentMethodTitle'));
      } else {
        return redirect()->route('homepage')->withError(trans('icommerce::order.Order no fount'));
      }
    } else {
      return redirect()->route('homepage')->withError(trans('icommerce::order.Order no fount'));
    }

  }
}
