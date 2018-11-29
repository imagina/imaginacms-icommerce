<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\CouponProduct;
use Modules\Icommerce\Http\Requests\CreateCouponProductRequest;
use Modules\Icommerce\Http\Requests\UpdateCouponProductRequest;
use Modules\Icommerce\Repositories\CouponProductRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CouponProductController extends AdminBaseController
{
    /**
     * @var CouponProductRepository
     */
    private $couponproduct;

    public function __construct(CouponProductRepository $couponproduct)
    {
        parent::__construct();

        $this->couponproduct = $couponproduct;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$couponproducts = $this->couponproduct->all();

        return view('icommerce::admin.couponproducts.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.couponproducts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCouponProductRequest $request
     * @return Response
     */
    public function store(CreateCouponProductRequest $request)
    {
        $this->couponproduct->create($request->all());

        return redirect()->route('admin.icommerce.couponproduct.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::couponproducts.title.couponproducts')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CouponProduct $couponproduct
     * @return Response
     */
    public function edit(CouponProduct $couponproduct)
    {
        return view('icommerce::admin.couponproducts.edit', compact('couponproduct'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CouponProduct $couponproduct
     * @param  UpdateCouponProductRequest $request
     * @return Response
     */
    public function update(CouponProduct $couponproduct, UpdateCouponProductRequest $request)
    {
        $this->couponproduct->update($couponproduct, $request->all());

        return redirect()->route('admin.icommerce.couponproduct.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::couponproducts.title.couponproducts')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CouponProduct $couponproduct
     * @return Response
     */
    public function destroy(CouponProduct $couponproduct)
    {
        $this->couponproduct->destroy($couponproduct);

        return redirect()->route('admin.icommerce.couponproduct.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::couponproducts.title.couponproducts')]));
    }
}
