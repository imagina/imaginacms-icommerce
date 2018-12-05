<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\RelatedProduct;
use Modules\Icommerce\Http\Requests\CreateRelatedProductRequest;
use Modules\Icommerce\Http\Requests\UpdateRelatedProductRequest;
use Modules\Icommerce\Repositories\RelatedProductRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class RelatedProductController extends AdminBaseController
{
    /**
     * @var RelatedProductRepository
     */
    private $relatedproduct;

    public function __construct(RelatedProductRepository $relatedproduct)
    {
        parent::__construct();

        $this->relatedproduct = $relatedproduct;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$relatedproducts = $this->relatedproduct->all();

        return view('icommerce::admin.relatedproducts.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.relatedproducts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRelatedProductRequest $request
     * @return Response
     */
    public function store(CreateRelatedProductRequest $request)
    {
        $this->relatedproduct->create($request->all());

        return redirect()->route('admin.icommerce.relatedproduct.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::relatedproducts.title.relatedproducts')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  RelatedProduct $relatedproduct
     * @return Response
     */
    public function edit(RelatedProduct $relatedproduct)
    {
        return view('icommerce::admin.relatedproducts.edit', compact('relatedproduct'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RelatedProduct $relatedproduct
     * @param  UpdateRelatedProductRequest $request
     * @return Response
     */
    public function update(RelatedProduct $relatedproduct, UpdateRelatedProductRequest $request)
    {
        $this->relatedproduct->update($relatedproduct, $request->all());

        return redirect()->route('admin.icommerce.relatedproduct.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::relatedproducts.title.relatedproducts')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  RelatedProduct $relatedproduct
     * @return Response
     */
    public function destroy(RelatedProduct $relatedproduct)
    {
        $this->relatedproduct->destroy($relatedproduct);

        return redirect()->route('admin.icommerce.relatedproduct.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::relatedproducts.title.relatedproducts')]));
    }
}
