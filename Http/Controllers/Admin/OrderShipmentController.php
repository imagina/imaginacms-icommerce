<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\OrderShipment;
use Modules\Icommerce\Http\Requests\CreateOrderShipmentRequest;
use Modules\Icommerce\Http\Requests\UpdateOrderShipmentRequest;
use Modules\Icommerce\Repositories\OrderShipmentRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class OrderShipmentController extends AdminBaseController
{
    /**
     * @var OrderShipmentRepository
     */
    private $ordershipment;

    public function __construct(OrderShipmentRepository $ordershipment)
    {
        parent::__construct();

        $this->ordershipment = $ordershipment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$ordershipments = $this->ordershipment->all();

        return view('icommerce::admin.ordershipments.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.ordershipments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderShipmentRequest $request
     * @return Response
     */
    public function store(CreateOrderShipmentRequest $request)
    {
        $this->ordershipment->create($request->all());

        return redirect()->route('admin.icommerce.ordershipment.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::ordershipments.title.ordershipments')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  OrderShipment $ordershipment
     * @return Response
     */
    public function edit(OrderShipment $ordershipment)
    {
        return view('icommerce::admin.ordershipments.edit', compact('ordershipment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OrderShipment $ordershipment
     * @param  UpdateOrderShipmentRequest $request
     * @return Response
     */
    public function update(OrderShipment $ordershipment, UpdateOrderShipmentRequest $request)
    {
        $this->ordershipment->update($ordershipment, $request->all());

        return redirect()->route('admin.icommerce.ordershipment.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::ordershipments.title.ordershipments')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  OrderShipment $ordershipment
     * @return Response
     */
    public function destroy(OrderShipment $ordershipment)
    {
        $this->ordershipment->destroy($ordershipment);

        return redirect()->route('admin.icommerce.ordershipment.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::ordershipments.title.ordershipments')]));
    }
}
