<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Coupon_History;
use Modules\Icommerce\Http\Requests\CreateCoupon_HistoryRequest;
use Modules\Icommerce\Http\Requests\UpdateCoupon_HistoryRequest;
use Modules\Icommerce\Repositories\Coupon_HistoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class Coupon_HistoryController extends AdminBaseController
{
    /**
     * @var Coupon_HistoryRepository
     */
    private $coupon_history;

    public function __construct(Coupon_HistoryRepository $coupon_history)
    {
        parent::__construct();

        $this->coupon_history = $coupon_history;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$coupon_histories = $this->coupon_history->all();

        return view('icommerce::admin.coupon_histories.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.coupon_histories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCoupon_HistoryRequest $request
     * @return Response
     */
    public function store(CreateCoupon_HistoryRequest $request)
    {
        $this->coupon_history->create($request->all());

        return redirect()->route('admin.icommerce.coupon_history.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::coupon_histories.title.coupon_histories')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Coupon_History $coupon_history
     * @return Response
     */
    public function edit(Coupon_History $coupon_history)
    {
        return view('icommerce::admin.coupon_histories.edit', compact('coupon_history'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Coupon_History $coupon_history
     * @param  UpdateCoupon_HistoryRequest $request
     * @return Response
     */
    public function update(Coupon_History $coupon_history, UpdateCoupon_HistoryRequest $request)
    {
        $this->coupon_history->update($coupon_history, $request->all());

        return redirect()->route('admin.icommerce.coupon_history.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::coupon_histories.title.coupon_histories')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Coupon_History $coupon_history
     * @return Response
     */
    public function destroy(Coupon_History $coupon_history)
    {
        $this->coupon_history->destroy($coupon_history);

        return redirect()->route('admin.icommerce.coupon_history.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::coupon_histories.title.coupon_histories')]));
    }
}
