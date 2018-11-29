<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\ProductDiscount;
use Modules\Icommerce\Http\Requests\CreateProductDiscountRequest;
use Modules\Icommerce\Http\Requests\UpdateProductDiscountRequest;
use Modules\Icommerce\Repositories\ProductDiscountRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ProductDiscountController extends AdminBaseController
{
    /**
     * @var ProductDiscountRepository
     */
    private $productdiscount;

    public function __construct(ProductDiscountRepository $productdiscount)
    {
        parent::__construct();

        $this->productdiscount = $productdiscount;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$productdiscounts = $this->productdiscount->all();

        return view('icommerce::admin.productdiscounts.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.productdiscounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductDiscountRequest $request
     * @return Response
     */
    public function store(CreateProductDiscountRequest $request)
    {
        $this->productdiscount->create($request->all());

        return redirect()->route('admin.icommerce.productdiscount.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::productdiscounts.title.productdiscounts')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProductDiscount $productdiscount
     * @return Response
     */
    public function edit(ProductDiscount $productdiscount)
    {
        return view('icommerce::admin.productdiscounts.edit', compact('productdiscount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductDiscount $productdiscount
     * @param  UpdateProductDiscountRequest $request
     * @return Response
     */
    public function update(ProductDiscount $productdiscount, UpdateProductDiscountRequest $request)
    {
        $this->productdiscount->update($productdiscount, $request->all());

        return redirect()->route('admin.icommerce.productdiscount.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::productdiscounts.title.productdiscounts')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductDiscount $productdiscount
     * @return Response
     */
    public function destroy(ProductDiscount $productdiscount)
    {
        $this->productdiscount->destroy($productdiscount);

        return redirect()->route('admin.icommerce.productdiscount.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::productdiscounts.title.productdiscounts')]));
    }
}
