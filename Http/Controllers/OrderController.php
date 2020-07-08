<?php

namespace Modules\Icommerce\Http\Controllers;

use Modules\Core\Http\Controllers\BasePublicController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Contracts\Authentication;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Repositories\PaymentMethodRepository;


class OrderController extends BasePublicController
{
    protected $auth;
    private $order;
    private $payments;

    /**
     * Display a listing of the resource.
     * @param OrderRepository $order
     * @param PaymentMethodRepository $payments
     */
    public function __construct(
        OrderRepository $order,
        PaymentMethodRepository $payments
    ){
        parent::__construct();
        $this->auth = app(Authentication::class);
        $this->order = $order;
        $this->payments = $payments;
    }

    public function index()
    {
        $tpl = 'icommerce::frontend.orders.index';
        $ttpl = 'icommerce.orders.index';

        if (view()->exists($ttpl)) $tpl = $ttpl;
        $user = $this->auth->user();
        $orders=[];
        if($user){
            $orders = $this->order->getItemsBy((object)["filter"=>(object)["customer"=>$user->id],"include"=>[],"page"=>1,"take"=>8,"user"=>$user]);
        }

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

        if (view()->exists($ttpl)) $tpl = $ttpl;
        if (!isset($request->key)) {
            $user = $this->auth->user();
            $order = $this->order->getItem($request->id,(object)["filter"=>(object)["customer"=>$user->id],"include"=>[],"user"=>$user]);
        }else
            $order = $this->order->getItem($request->id,(object)["filter"=>(object)["key"=>$request->key],"include"=>[]]);

        $products = [];
        if (isset($order) && !empty($order)) {
            if ($order->shipping_amount>0){
                $subtotal = $order->total - $order->shipping_amount;
            }else{
                $subtotal = $order->total;
            }
            if ($order->tax_amount){
                $subtotal = $subtotal - $order->tax_amount;
            }
            return view($tpl, compact('order', 'user','subtotal'));

        } else
            return redirect()->route('homepage')->withError(trans('icommerce::orders.order_not_found'));



    }

}
