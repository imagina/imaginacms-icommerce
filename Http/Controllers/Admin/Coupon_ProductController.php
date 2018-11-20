<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Coupon_Product;
use Modules\Icommerce\Http\Requests\CreateCoupon_ProductRequest;
use Modules\Icommerce\Http\Requests\UpdateCoupon_ProductRequest;
use Modules\Icommerce\Repositories\Coupon_ProductRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class Coupon_ProductController extends AdminBaseController
{
    /**
     * @var Coupon_ProductRepository
     */
    private $coupon_product;

    public function __construct(Coupon_ProductRepository $coupon_product)
    {
        parent::__construct();

        $this->coupon_product = $coupon_product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$coupon_products = $this->coupon_product->all();

        return view('icommerce::admin.coupon_products.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.coupon_products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCoupon_ProductRequest $request
     * @return Response
     */
    public function store(CreateCoupon_ProductRequest $request)
    {
        $this->coupon_product->create($request->all());

        return redirect()->route('admin.icommerce.coupon_product.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::coupon_products.title.coupon_products')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Coupon_Product $coupon_product
     * @return Response
     */
    public function edit(Coupon_Product $coupon_product)
    {
        return view('icommerce::admin.coupon_products.edit', compact('coupon_product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Coupon_Product $coupon_product
     * @param  UpdateCoupon_ProductRequest $request
     * @return Response
     */
    public function update(Coupon_Product $coupon_product, UpdateCoupon_ProductRequest $request)
    {
        $this->coupon_product->update($coupon_product, $request->all());

        return redirect()->route('admin.icommerce.coupon_product.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::coupon_products.title.coupon_products')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Coupon_Product $coupon_product
     * @return Response
     */
    public function destroy(Coupon_Product $coupon_product)
    {
        $this->coupon_product->destroy($coupon_product);

        return redirect()->route('admin.icommerce.coupon_product.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::coupon_products.title.coupon_products')]));
    }
}
