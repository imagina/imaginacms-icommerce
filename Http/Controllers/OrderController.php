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
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Entities\Product_Discount;
use Modules\Icommerce\Entities\Payment;
use Modules\User\Contracts\Authentication;
use Modules\Notification\Services\Notification;
use Modules\Icommerce\Repositories\CurrencyRepository;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Transformers\ProductTransformer;
use Session;

class OrderController extends BasePublicController
{
     private $cart;
     private $currency;
     protected $auth;
    private $notification;
    private $order;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function __construct(CurrencyRepository $currency, Notification $notification,OrderRepository $order)
    {
        parent::__construct();
        $this->cart = new Carting();
        $this->currency = $currency;
        $this->auth = app(Authentication::class);
        $this->notification = $notification;
        $this->order = $order;

    }

    public function index()
    {
        $tpl = 'icommerce::frontend.orders.index';
        $ttpl='icommerce.orders.index';

        if(view()->exists($ttpl)) $tpl = $ttpl;
        $user = $this->auth->user();
        $orders = $this->order->whereUser($user->id);

        return view($tpl, compact('orders', 'user'));
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $tpl = 'icommerce::frontend.orders.show';
        $ttpl='icommerce.orders.show';

        if(view()->exists($ttpl)) $tpl = $ttpl;
        $user = $this->auth->user();
        $order = $this->order->findByUser($id,$user->id);
        $products=[];
        if(!empty($order)){
            foreach ($order->products as $product) {
                array_push($products,[
                    "title" => $product->title,
                    "sku" => $product->sku,
                    "quantity" => $product->pivot->quantity,
                    "price" => $product->pivot->price,
                    "total" => $product->pivot->total,
                ]);

            }
        }
    
        $products = json_encode($products);
        return view($tpl, compact('order', 'user',"products"));
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

        $cart = $this->getItems();
        $currency = $this->currency->getActive();
        
        $request["ip"]=$request->ip();
        $request["user_agent"]=$request->header('User-Agent');
        $request['order_status']=0;

        if($request->guestOrCustomer==2)
            $request['user_id']=1;
            
        try {
            $order = Order::create($request->all());
        } catch (Exception $e) {
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
            return response()->json([
            "status" => "500",
            "message" => trans('icommerce::checkout.alerts.error_order').$e->getMessage()
            ]);
        }
        
        try {
            foreach ($cart["items"] as $item) {
                Order_Product::create([
                    "order_id" => $order->id,
                    "product_id" => $item->id,
                    "title" => $item->name,
                    "quantity" => $item->quantity,
                    "price" => floatval($item->price),
                    "total" => floatval($item->quantity)*floatval($item->price),
                    "tax" => 0,
                    "reward" => 0,
                ]);
            }    
        } catch (Exception $e) {
           \Log::info($e->getMessage());
            return response()->json([
            "status" => "500",
            "message" => trans('icommerce::checkout.alerts.error_order').$e->getMessage()
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
            return response()->json([
            "status" => "500",
            "message" => trans('icommerce::checkout.alerts.error_order').$e->getMessage()
            ]);
        }
        
        //$this->notification->push('New Order', 'New generated order!', 'fa fa-check-square-o text-green', route('admin.icommerce.order.index'));
        Session::put('orderID', $order->id);
        $this->cart->clear();
        return response()->json([
            "status" => "202",
            "message" => trans('icommerce::checkout.alerts.order_created'),
            "url" => route($request->payment_method),
            "session" => session('orderID')
            ]);
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
    public function getItems() {
        $items = $this->cart->getItems();
        $weight = 0;

        foreach ($items as $index => $item){
            $item->weight ? $weight += $item->weight : false;
        }

    return [
            'items' => $items,
            'quantity' => $this->cart->totalQuantity(),
            'total' => number_format($this->cart->getTotal(),2),
            'weight' => $weight
        ];
    }
    public function email()
    {
        $order = $this->order->find(44);
        $products=[];
        foreach ($order->products as $product) {
            array_push($products,[
                "title" => $product->title,
                "sku" => $product->sku,
                "quantity" => $product->pivot->quantity,
                "price" => $product->pivot->price,
                "total" => $product->pivot->total,
            ]);
        }

        $userEmail = $order->email;
        $userFirstname = "{$order->first_name} {$order->last_name}";
        

        $content=[
            'order'=> $order,
            'products' => $products,
            'user' => $userFirstname
        ];

        $data = array(
            'title' => null,
            'intro'=>null,
            'content'=>$content,

        );
        return view("icommerce::email.success_order", compact('data'));
    }
}
