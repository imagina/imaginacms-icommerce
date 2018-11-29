<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\CouponOrderHistory;
use Modules\Icommerce\Http\Requests\CreateCouponHistoryRequest;
use Modules\Icommerce\Http\Requests\UpdateCouponHistoryRequest;
use Modules\Icommerce\Repositories\CouponHistoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CouponHistoryController extends AdminBaseController
{
    /**
     * @var CouponHistoryRepository
     */
    private $couponhistory;

    public function __construct(CouponHistoryRepository $couponhistory)
    {
        parent::__construct();

        $this->couponhistory = $couponhistory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$couponhistories = $this->couponhistory->all();

        return view('icommerce::admin.couponhistories.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.couponhistories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCouponHistoryRequest $request
     * @return Response
     */
    public function store(CreateCouponHistoryRequest $request)
    {
        $this->couponhistory->create($request->all());

        return redirect()->route('admin.icommerce.couponhistory.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::couponhistories.title.couponhistories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CouponOrderHistory $couponhistory
     * @return Response
     */
    public function edit(CouponOrderHistory $couponhistory)
    {
        return view('icommerce::admin.couponhistories.edit', compact('couponhistory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CouponOrderHistory $couponhistory
     * @param  UpdateCouponHistoryRequest $request
     * @return Response
     */
    public function update(CouponOrderHistory $couponhistory, UpdateCouponHistoryRequest $request)
    {
        $this->couponhistory->update($couponhistory, $request->all());

        return redirect()->route('admin.icommerce.couponhistory.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::couponhistories.title.couponhistories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CouponOrderHistory $couponhistory
     * @return Response
     */
    public function destroy(CouponOrderHistory $couponhistory)
    {
        $this->couponhistory->destroy($couponhistory);

        return redirect()->route('admin.icommerce.couponhistory.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::couponhistories.title.couponhistories')]));
    }
}
