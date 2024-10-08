<?php

namespace Modules\Icommerce\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Transformers\OrderTransformer;
use Modules\User\Contracts\Authentication;

class OrderController extends BasePublicController
{
    protected $auth;

    private $order;

    private $payments;

    /**
     * Display a listing of the resource.
     */
    public function __construct(
        OrderRepository $order,
        PaymentMethodRepository $payments
    ) {
        parent::__construct();
        $this->auth = app(Authentication::class);
        $this->order = $order;
        $this->payments = $payments;
    }

    public function index()
    {
        $tpl = 'icommerce::frontend.orders.index';
        $ttpl = 'icommerce.orders.index';

        if (view()->exists($ttpl)) {
            $tpl = $ttpl;
        }
        $user = $this->auth->user();
        $orders = [];
        if ($user) {
            $orders = $this->order->getItemsBy((object) ['filter' => (object) ['customer' => $user->id], 'include' => [], 'page' => 1, 'take' => 8, 'user' => $user]);
        }

        $organization = null;
        if (isset(tenant()->id)) {
            $organization = tenant();
        }

        return view($tpl, compact('orders', 'user', 'organization'));
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request): Response
    {
        $tpl = 'icommerce::frontend.orders.show';
        $ttpl = 'icommerce.orders.show';

        if (view()->exists($ttpl)) {
            $tpl = $ttpl;
        }
        if (! isset($request->orderKey)) {
            $user = $this->auth->user();
            $order = $this->order->getItem($request->orderId, (object) ['filter' => (object) ['customer' => $user->id], 'include' => []]);
        } else {
            $order = $this->order->getItem($request->orderKey, (object) ['filter' => (object) ['field' => 'key'], 'include' => []]);
        }

        $products = [];

        $organization = null;
        if (isset(tenant()->id)) {
            $organization = tenant();
        }

        if (isset($order) && ! empty($order)) {
            if ($order->shipping_amount > 0) {
                $subtotal = $order->total + $order->coupon_total - $order->shipping_amount;
            } else {
                $subtotal = $order->total;
            }
            if ($order->tax_amount) {
                $subtotal = $subtotal - $order->tax_amount;
            }
            $order = new OrderTransformer($order);

            return view($tpl, compact('order', 'subtotal', 'organization'));
        } else {
            return redirect()->route('homepage')->withError(trans('icommerce::orders.order_not_found'));
        }
    }

    /**
     *  From link to payment 
     */
    public function reedirectToPayment(Request $request)
    {

        try{

            $orderId = base64_decode($request->encrip);

            //Search Order
            $order = $this->order->getItem($orderId);

            //Validations
            if(is_null($order)) throw new \Exception("Order not found", 404);
            if($order->status_id==13) throw new \Exception("Order has already been processed", 404);
            if(!isset($order->paymentMethod)) throw new \Exception("Payment Method not found", 404);

            //Get payment method
            $paymentMethod =  $order->paymentMethod;

            //Data to Init method in Payment Method Module
            $data = ["orderId" => $order->id,"orderID" => $order->id];

            //Get Response
            $paymentMethodResponse = json_decode(app($paymentMethod->options->init)->init(new Request($data))->content())->data;

            //Validation
            if(!isset($paymentMethodResponse->redirectRoute)) throw new \Exception("redirect is null", 404);

            //Reedirection
            return redirect($paymentMethodResponse->redirectRoute);
         
        }catch(\Exception $e){

            $errorMsj = $e->getMessage();

            \Log::error($errorMsj);
            return redirect()->route('home')->withError("ERROR: ".$errorMsj);
           
        }

    }
}
