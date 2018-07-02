<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Order_Shipment;
use Modules\Icommerce\Http\Requests\CreateOrder_ShipmentRequest;
use Modules\Icommerce\Http\Requests\UpdateOrder_ShipmentRequest;
use Modules\Icommerce\Repositories\Order_ShipmentRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class Order_ShipmentController extends AdminBaseController
{
    /**
     * @var Order_ShipmentRepository
     */
    private $order_shipment;

    public function __construct(Order_ShipmentRepository $order_shipment)
    {
        parent::__construct();

        $this->order_shipment = $order_shipment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$order_shipments = $this->order_shipment->all();

        return view('icommerce::admin.order_shipments.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.order_shipments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrder_ShipmentRequest $request
     * @return Response
     */
    public function store(CreateOrder_ShipmentRequest $request)
    {
        $this->order_shipment->create($request->all());

        return redirect()->route('admin.icommerce.order_shipment.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::order_shipments.title.order_shipments')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order_Shipment $order_shipment
     * @return Response
     */
    public function edit(Order_Shipment $order_shipment)
    {
        return view('icommerce::admin.order_shipments.edit', compact('order_shipment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Order_Shipment $order_shipment
     * @param  UpdateOrder_ShipmentRequest $request
     * @return Response
     */
    public function update(Order_Shipment $order_shipment, UpdateOrder_ShipmentRequest $request)
    {
        $this->order_shipment->update($order_shipment, $request->all());

        return redirect()->route('admin.icommerce.order_shipment.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::order_shipments.title.order_shipments')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order_Shipment $order_shipment
     * @return Response
     */
    public function destroy(Order_Shipment $order_shipment)
    {
        $this->order_shipment->destroy($order_shipment);

        return redirect()->route('admin.icommerce.order_shipment.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::order_shipments.title.order_shipments')]));
    }
}
