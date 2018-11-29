<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\OrderStatusHistory;
use Modules\Icommerce\Http\Requests\CreateOrderHistoryRequest;
use Modules\Icommerce\Http\Requests\UpdateOrderHistoryRequest;
use Modules\Icommerce\Repositories\OrderHistoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class OrderHistoryController extends AdminBaseController
{
    /**
     * @var OrderHistoryRepository
     */
    private $orderhistory;

    public function __construct(OrderHistoryRepository $orderhistory)
    {
        parent::__construct();

        $this->orderhistory = $orderhistory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$orderhistories = $this->orderhistory->all();

        return view('icommerce::admin.orderhistories.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.orderhistories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderHistoryRequest $request
     * @return Response
     */
    public function store(CreateOrderHistoryRequest $request)
    {
        $this->orderhistory->create($request->all());

        return redirect()->route('admin.icommerce.orderhistory.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::orderhistories.title.orderhistories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  OrderStatusHistory $orderhistory
     * @return Response
     */
    public function edit(OrderStatusHistory $orderhistory)
    {
        return view('icommerce::admin.orderhistories.edit', compact('orderhistory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OrderStatusHistory $orderhistory
     * @param  UpdateOrderHistoryRequest $request
     * @return Response
     */
    public function update(OrderStatusHistory $orderhistory, UpdateOrderHistoryRequest $request)
    {
        $this->orderhistory->update($orderhistory, $request->all());

        return redirect()->route('admin.icommerce.orderhistory.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::orderhistories.title.orderhistories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  OrderStatusHistory $orderhistory
     * @return Response
     */
    public function destroy(OrderStatusHistory $orderhistory)
    {
        $this->orderhistory->destroy($orderhistory);

        return redirect()->route('admin.icommerce.orderhistory.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::orderhistories.title.orderhistories')]));
    }
}
