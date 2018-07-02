<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Product_Option;
use Modules\Icommerce\Http\Requests\CreateProduct_OptionRequest;
use Modules\Icommerce\Http\Requests\UpdateProduct_OptionRequest;
use Modules\Icommerce\Repositories\Product_OptionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class Product_OptionController extends AdminBaseController
{
    /**
     * @var Product_OptionRepository
     */
    private $product_option;

    public function __construct(Product_OptionRepository $product_option)
    {
        parent::__construct();

        $this->product_option = $product_option;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$product_options = $this->product_option->all();

        return view('icommerce::admin.product_options.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.product_options.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProduct_OptionRequest $request
     * @return Response
     */
    public function store(CreateProduct_OptionRequest $request)
    {
        $this->product_option->create($request->all());

        return redirect()->route('admin.icommerce.product_option.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::product_options.title.product_options')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product_Option $product_option
     * @return Response
     */
    public function edit(Product_Option $product_option)
    {
        return view('icommerce::admin.product_options.edit', compact('product_option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Product_Option $product_option
     * @param  UpdateProduct_OptionRequest $request
     * @return Response
     */
    public function update(Product_Option $product_option, UpdateProduct_OptionRequest $request)
    {
        $this->product_option->update($product_option, $request->all());

        return redirect()->route('admin.icommerce.product_option.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::product_options.title.product_options')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product_Option $product_option
     * @return Response
     */
    public function destroy(Product_Option $product_option)
    {
        $this->product_option->destroy($product_option);

        return redirect()->route('admin.icommerce.product_option.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::product_options.title.product_options')]));
    }
}
