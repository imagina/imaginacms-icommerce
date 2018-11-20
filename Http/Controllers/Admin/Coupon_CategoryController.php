<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Coupon_Category;
use Modules\Icommerce\Http\Requests\CreateCoupon_CategoryRequest;
use Modules\Icommerce\Http\Requests\UpdateCoupon_CategoryRequest;
use Modules\Icommerce\Repositories\Coupon_CategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class Coupon_CategoryController extends AdminBaseController
{
    /**
     * @var Coupon_CategoryRepository
     */
    private $coupon_category;

    public function __construct(Coupon_CategoryRepository $coupon_category)
    {
        parent::__construct();

        $this->coupon_category = $coupon_category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$coupon_categories = $this->coupon_category->all();

        return view('icommerce::admin.coupon_categories.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.coupon_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCoupon_CategoryRequest $request
     * @return Response
     */
    public function store(CreateCoupon_CategoryRequest $request)
    {
        $this->coupon_category->create($request->all());

        return redirect()->route('admin.icommerce.coupon_category.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::coupon_categories.title.coupon_categories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Coupon_Category $coupon_category
     * @return Response
     */
    public function edit(Coupon_Category $coupon_category)
    {
        return view('icommerce::admin.coupon_categories.edit', compact('coupon_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Coupon_Category $coupon_category
     * @param  UpdateCoupon_CategoryRequest $request
     * @return Response
     */
    public function update(Coupon_Category $coupon_category, UpdateCoupon_CategoryRequest $request)
    {
        $this->coupon_category->update($coupon_category, $request->all());

        return redirect()->route('admin.icommerce.coupon_category.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::coupon_categories.title.coupon_categories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Coupon_Category $coupon_category
     * @return Response
     */
    public function destroy(Coupon_Category $coupon_category)
    {
        $this->coupon_category->destroy($coupon_category);

        return redirect()->route('admin.icommerce.coupon_category.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::coupon_categories.title.coupon_categories')]));
    }
}
