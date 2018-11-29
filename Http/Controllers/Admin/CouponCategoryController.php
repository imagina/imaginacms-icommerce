<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\CouponCategory;
use Modules\Icommerce\Http\Requests\CreateCouponCategoryRequest;
use Modules\Icommerce\Http\Requests\UpdateCouponCategoryRequest;
use Modules\Icommerce\Repositories\CouponCategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CouponCategoryController extends AdminBaseController
{
    /**
     * @var CouponCategoryRepository
     */
    private $couponcategory;

    public function __construct(CouponCategoryRepository $couponcategory)
    {
        parent::__construct();

        $this->couponcategory = $couponcategory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$couponcategories = $this->couponcategory->all();

        return view('icommerce::admin.couponcategories.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.couponcategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCouponCategoryRequest $request
     * @return Response
     */
    public function store(CreateCouponCategoryRequest $request)
    {
        $this->couponcategory->create($request->all());

        return redirect()->route('admin.icommerce.couponcategory.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::couponcategories.title.couponcategories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CouponCategory $couponcategory
     * @return Response
     */
    public function edit(CouponCategory $couponcategory)
    {
        return view('icommerce::admin.couponcategories.edit', compact('couponcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CouponCategory $couponcategory
     * @param  UpdateCouponCategoryRequest $request
     * @return Response
     */
    public function update(CouponCategory $couponcategory, UpdateCouponCategoryRequest $request)
    {
        $this->couponcategory->update($couponcategory, $request->all());

        return redirect()->route('admin.icommerce.couponcategory.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::couponcategories.title.couponcategories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CouponCategory $couponcategory
     * @return Response
     */
    public function destroy(CouponCategory $couponcategory)
    {
        $this->couponcategory->destroy($couponcategory);

        return redirect()->route('admin.icommerce.couponcategory.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::couponcategories.title.couponcategories')]));
    }
}
