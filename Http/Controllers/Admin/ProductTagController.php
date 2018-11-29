<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\ProductTag;
use Modules\Icommerce\Http\Requests\CreateProductTagRequest;
use Modules\Icommerce\Http\Requests\UpdateProductTagRequest;
use Modules\Icommerce\Repositories\ProductTagRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ProductTagController extends AdminBaseController
{
    /**
     * @var ProductTagRepository
     */
    private $producttag;

    public function __construct(ProductTagRepository $producttag)
    {
        parent::__construct();

        $this->producttag = $producttag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$producttags = $this->producttag->all();

        return view('icommerce::admin.producttags.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.producttags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductTagRequest $request
     * @return Response
     */
    public function store(CreateProductTagRequest $request)
    {
        $this->producttag->create($request->all());

        return redirect()->route('admin.icommerce.producttag.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::producttags.title.producttags')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProductTag $producttag
     * @return Response
     */
    public function edit(ProductTag $producttag)
    {
        return view('icommerce::admin.producttags.edit', compact('producttag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductTag $producttag
     * @param  UpdateProductTagRequest $request
     * @return Response
     */
    public function update(ProductTag $producttag, UpdateProductTagRequest $request)
    {
        $this->producttag->update($producttag, $request->all());

        return redirect()->route('admin.icommerce.producttag.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::producttags.title.producttags')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductTag $producttag
     * @return Response
     */
    public function destroy(ProductTag $producttag)
    {
        $this->producttag->destroy($producttag);

        return redirect()->route('admin.icommerce.producttag.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::producttags.title.producttags')]));
    }
}
