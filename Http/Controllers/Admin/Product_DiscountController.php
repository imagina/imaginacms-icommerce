<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Product_Discount;
use Modules\Icommerce\Http\Requests\CreateProduct_DiscountRequest;
use Modules\Icommerce\Http\Requests\UpdateProduct_DiscountRequest;
use Modules\Icommerce\Repositories\Product_DiscountRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class Product_DiscountController extends AdminBaseController
{
    /**
     * @var Product_DiscountRepository
     */
    private $product_discount;

    public function __construct(Product_DiscountRepository $product_discount)
    {
        parent::__construct();

        $this->product_discount = $product_discount;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$product_discounts = $this->product_discount->all();

        return view('icommerce::admin.product_discounts.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.product_discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProduct_DiscountRequest $request
     * @return Response
     */
    public function store(CreateProduct_DiscountRequest $request)
    {
        $this->product_discount->create($request->all());

        return redirect()->route('admin.icommerce.product_discount.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::product_discounts.title.product_discounts')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product_Discount $product_discount
     * @return Response
     */
    public function edit(Product_Discount $product_discount)
    {
        return view('icommerce::admin.product_discounts.edit', compact('product_discount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Product_Discount $product_discount
     * @param  UpdateProduct_DiscountRequest $request
     * @return Response
     */
    public function update(Product_Discount $product_discount, UpdateProduct_DiscountRequest $request)
    {
        $this->product_discount->update($product_discount, $request->all());

        return redirect()->route('admin.icommerce.product_discount.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::product_discounts.title.product_discounts')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product_Discount $product_discount
     * @return Response
     */
    public function destroy(Product_Discount $product_discount)
    {
        $this->product_discount->destroy($product_discount);

        return redirect()->route('admin.icommerce.product_discount.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::product_discounts.title.product_discounts')]));
    }
}
