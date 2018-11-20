<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Product_Option_Value;
use Modules\Icommerce\Http\Requests\CreateProduct_Option_ValueRequest;
use Modules\Icommerce\Http\Requests\UpdateProduct_Option_ValueRequest;
use Modules\Icommerce\Repositories\Product_Option_ValueRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class Product_Option_ValueController extends AdminBaseController
{
    /**
     * @var Product_Option_ValueRepository
     */
    private $product_option_value;

    public function __construct(Product_Option_ValueRepository $product_option_value)
    {
        parent::__construct();

        $this->product_option_value = $product_option_value;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$product_option_values = $this->product_option_value->all();

        return view('icommerce::admin.product_option_values.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.product_option_values.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProduct_Option_ValueRequest $request
     * @return Response
     */
    public function store(CreateProduct_Option_ValueRequest $request)
    {
        $this->product_option_value->create($request->all());

        return redirect()->route('admin.icommerce.product_option_value.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::product_option_values.title.product_option_values')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product_Option_Value $product_option_value
     * @return Response
     */
    public function edit(Product_Option_Value $product_option_value)
    {
        return view('icommerce::admin.product_option_values.edit', compact('product_option_value'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Product_Option_Value $product_option_value
     * @param  UpdateProduct_Option_ValueRequest $request
     * @return Response
     */
    public function update(Product_Option_Value $product_option_value, UpdateProduct_Option_ValueRequest $request)
    {
        $this->product_option_value->update($product_option_value, $request->all());

        return redirect()->route('admin.icommerce.product_option_value.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::product_option_values.title.product_option_values')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product_Option_Value $product_option_value
     * @return Response
     */
    public function destroy(Product_Option_Value $product_option_value)
    {
        $this->product_option_value->destroy($product_option_value);

        return redirect()->route('admin.icommerce.product_option_value.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::product_option_values.title.product_option_values')]));
    }
}
