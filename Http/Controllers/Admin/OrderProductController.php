<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\OrderProduct;
use Modules\Icommerce\Http\Requests\CreateOrderProductRequest;
use Modules\Icommerce\Http\Requests\UpdateOrderProductRequest;
use Modules\Icommerce\Repositories\OrderProductRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class OrderProductController extends AdminBaseController
{
    /**
     * @var OrderProductRepository
     */
    private $orderproduct;

    public function __construct(OrderProductRepository $orderproduct)
    {
        parent::__construct();

        $this->orderproduct = $orderproduct;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$orderproducts = $this->orderproduct->all();

        return view('icommerce::admin.orderproducts.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.orderproducts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderProductRequest $request
     * @return Response
     */
    public function store(CreateOrderProductRequest $request)
    {
        $this->orderproduct->create($request->all());

        return redirect()->route('admin.icommerce.orderproduct.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::orderproducts.title.orderproducts')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  OrderProduct $orderproduct
     * @return Response
     */
    public function edit(OrderProduct $orderproduct)
    {
        return view('icommerce::admin.orderproducts.edit', compact('orderproduct'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OrderProduct $orderproduct
     * @param  UpdateOrderProductRequest $request
     * @return Response
     */
    public function update(OrderProduct $orderproduct, UpdateOrderProductRequest $request)
    {
        $this->orderproduct->update($orderproduct, $request->all());

        return redirect()->route('admin.icommerce.orderproduct.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::orderproducts.title.orderproducts')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  OrderProduct $orderproduct
     * @return Response
     */
    public function destroy(OrderProduct $orderproduct)
    {
        $this->orderproduct->destroy($orderproduct);

        return redirect()->route('admin.icommerce.orderproduct.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::orderproducts.title.orderproducts')]));
    }
}
