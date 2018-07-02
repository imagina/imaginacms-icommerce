<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Order;
use Modules\Icommerce\Entities\Order_Status;
use Modules\Icommerce\Http\Requests\CreateOrderRequest;
use Modules\Icommerce\Http\Requests\UpdateOrderRequest;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class OrderController extends AdminBaseController
{
    /**
     * @var OrderRepository
     */
    private $order;
    
    public function __construct(OrderRepository $order)
    {
        parent::__construct();

        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
      
        $orders = $this->order->all();
        return view('icommerce::admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderRequest $request
     * @return Response
     */
    public function store(CreateOrderRequest $request)
    {
        $this->order->create($request->all());

        return redirect()->route('admin.icommerce.order.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::orders.title.orders')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order $order
     * @return Response
     */
    public function edit(Order $order)
    {
        $order_status = new Order_Status();
        return view('icommerce::admin.orders.edit', compact('order','order_status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Order $order
     * @param  UpdateOrderRequest $request
     * @return Response
     */
    public function update(Order $order, UpdateOrderRequest $request)
    {
        $this->order->update($order, $request->all());

        return redirect()->route('admin.icommerce.order.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::orders.title.orders')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order $order
     * @return Response
     */
    public function destroy(Order $order)
    {
        $this->order->destroy($order);

        return redirect()->route('admin.icommerce.order.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::orders.title.orders')]));
    }
}
