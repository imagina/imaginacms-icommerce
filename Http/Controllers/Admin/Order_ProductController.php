<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Order_Product;
use Modules\Icommerce\Http\Requests\CreateOrder_ProductRequest;
use Modules\Icommerce\Http\Requests\UpdateOrder_ProductRequest;
use Modules\Icommerce\Repositories\Order_ProductRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class Order_ProductController extends AdminBaseController
{
    /**
     * @var Order_ProductRepository
     */
    private $order_product;

    public function __construct(Order_ProductRepository $order_product)
    {
        parent::__construct();

        $this->order_product = $order_product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$order_products = $this->order_product->all();

        return view('icommerce::admin.order_products.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.order_products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrder_ProductRequest $request
     * @return Response
     */
    public function store(CreateOrder_ProductRequest $request)
    {
        $this->order_product->create($request->all());

        return redirect()->route('admin.icommerce.order_product.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::order_products.title.order_products')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order_Product $order_product
     * @return Response
     */
    public function edit(Order_Product $order_product)
    {
        return view('icommerce::admin.order_products.edit', compact('order_product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Order_Product $order_product
     * @param  UpdateOrder_ProductRequest $request
     * @return Response
     */
    public function update(Order_Product $order_product, UpdateOrder_ProductRequest $request)
    {
        $this->order_product->update($order_product, $request->all());

        return redirect()->route('admin.icommerce.order_product.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::order_products.title.order_products')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order_Product $order_product
     * @return Response
     */
    public function destroy(Order_Product $order_product)
    {
        $this->order_product->destroy($order_product);

        return redirect()->route('admin.icommerce.order_product.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::order_products.title.order_products')]));
    }
}
