<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\ProductList;
use Modules\Icommerce\Http\Requests\ProductListRequest;
use Modules\Icommerce\Http\Requests\UpdateProductListRequest;
use Modules\Icommerce\Repositories\ProductListRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ProductListController extends AdminBaseController
{
    /**
     * @var ProductListRepository
     */
    private $productlist;

    public function __construct(ProductListRepository $productlist)
    {
        parent::__construct();

        $this->productlist = $productlist;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$productlists = $this->productlist->all();

        return view('icommerce::admin.productlists.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.productlists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductListRequest $request
     * @return Response
     */
    public function store(ProductListRequest $request)
    {
        $this->productlist->create($request->all());

        return redirect()->route('admin.icommerce.productlist.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::productlists.title.productlists')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProductList $productlist
     * @return Response
     */
    public function edit(ProductList $productlist)
    {
        return view('icommerce::admin.productlists.edit', compact('productlist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductList $productlist
     * @param  UpdateProductListRequest $request
     * @return Response
     */
    public function update(ProductList $productlist, UpdateProductListRequest $request)
    {
        $this->productlist->update($productlist, $request->all());

        return redirect()->route('admin.icommerce.productlist.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::productlists.title.productlists')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductList $productlist
     * @return Response
     */
    public function destroy(ProductList $productlist)
    {
        $this->productlist->destroy($productlist);

        return redirect()->route('admin.icommerce.productlist.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::productlists.title.productlists')]));
    }
}
