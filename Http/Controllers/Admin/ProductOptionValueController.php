<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\ProductOptionValue;
use Modules\Icommerce\Http\Requests\ProductOptionValueRequest;
use Modules\Icommerce\Http\Requests\UpdateProductOptionValueRequest;
use Modules\Icommerce\Repositories\ProductOptionValueRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ProductOptionValueController extends AdminBaseController
{
    /**
     * @var ProductOptionValueRepository
     */
    private $productoptionvalue;

    public function __construct(ProductOptionValueRepository $productoptionvalue)
    {
        parent::__construct();

        $this->productoptionvalue = $productoptionvalue;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$productoptionvalues = $this->productoptionvalue->all();

        return view('icommerce::admin.productoptionvalues.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.productoptionvalues.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductOptionValueRequest $request
     * @return Response
     */
    public function store(ProductOptionValueRequest $request)
    {
        $this->productoptionvalue->create($request->all());

        return redirect()->route('admin.icommerce.productoptionvalue.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::productoptionvalues.title.productoptionvalues')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProductOptionValue $productoptionvalue
     * @return Response
     */
    public function edit(ProductOptionValue $productoptionvalue)
    {
        return view('icommerce::admin.productoptionvalues.edit', compact('productoptionvalue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductOptionValue $productoptionvalue
     * @param  UpdateProductOptionValueRequest $request
     * @return Response
     */
    public function update(ProductOptionValue $productoptionvalue, ProductOptionValueRequest $request)
    {
        $this->productoptionvalue->update($productoptionvalue, $request->all());

        return redirect()->route('admin.icommerce.productoptionvalue.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::productoptionvalues.title.productoptionvalues')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductOptionValue $productoptionvalue
     * @return Response
     */
    public function destroy(ProductOptionValue $productoptionvalue)
    {
        $this->productoptionvalue->destroy($productoptionvalue);

        return redirect()->route('admin.icommerce.productoptionvalue.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::productoptionvalues.title.productoptionvalues')]));
    }
}
