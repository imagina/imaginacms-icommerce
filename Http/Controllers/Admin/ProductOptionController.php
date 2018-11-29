<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\ProductOption;
use Modules\Icommerce\Http\Requests\CreateProductOptionRequest;
use Modules\Icommerce\Http\Requests\UpdateProductOptionRequest;
use Modules\Icommerce\Repositories\ProductOptionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ProductOptionController extends AdminBaseController
{
    /**
     * @var ProductOptionRepository
     */
    private $productoption;

    public function __construct(ProductOptionRepository $productoption)
    {
        parent::__construct();

        $this->productoption = $productoption;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$productoptions = $this->productoption->all();

        return view('icommerce::admin.productoptions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.productoptions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductOptionRequest $request
     * @return Response
     */
    public function store(CreateProductOptionRequest $request)
    {
        $this->productoption->create($request->all());

        return redirect()->route('admin.icommerce.productoption.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::productoptions.title.productoptions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProductOption $productoption
     * @return Response
     */
    public function edit(ProductOption $productoption)
    {
        return view('icommerce::admin.productoptions.edit', compact('productoption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductOption $productoption
     * @param  UpdateProductOptionRequest $request
     * @return Response
     */
    public function update(ProductOption $productoption, UpdateProductOptionRequest $request)
    {
        $this->productoption->update($productoption, $request->all());

        return redirect()->route('admin.icommerce.productoption.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::productoptions.title.productoptions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductOption $productoption
     * @return Response
     */
    public function destroy(ProductOption $productoption)
    {
        $this->productoption->destroy($productoption);

        return redirect()->route('admin.icommerce.productoption.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::productoptions.title.productoptions')]));
    }
}
