<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\ShippingCourier;
use Modules\Icommerce\Http\Requests\CreateShippingCourierRequest;
use Modules\Icommerce\Http\Requests\UpdateShippingCourierRequest;
use Modules\Icommerce\Repositories\ShippingCourierRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ShippingCourierController extends AdminBaseController
{
    /**
     * @var ShippingCourierRepository
     */
    private $shippingcourier;

    public function __construct(ShippingCourierRepository $shippingcourier)
    {
        parent::__construct();

        $this->shippingcourier = $shippingcourier;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$shippingcouriers = $this->shippingcourier->all();

        return view('icommerce::admin.shippingcouriers.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.shippingcouriers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateShippingCourierRequest $request
     * @return Response
     */
    public function store(CreateShippingCourierRequest $request)
    {
        $this->shippingcourier->create($request->all());

        return redirect()->route('admin.icommerce.shippingcourier.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::shippingcouriers.title.shippingcouriers')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ShippingCourier $shippingcourier
     * @return Response
     */
    public function edit(ShippingCourier $shippingcourier)
    {
        return view('icommerce::admin.shippingcouriers.edit', compact('shippingcourier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ShippingCourier $shippingcourier
     * @param  UpdateShippingCourierRequest $request
     * @return Response
     */
    public function update(ShippingCourier $shippingcourier, UpdateShippingCourierRequest $request)
    {
        $this->shippingcourier->update($shippingcourier, $request->all());

        return redirect()->route('admin.icommerce.shippingcourier.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::shippingcouriers.title.shippingcouriers')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ShippingCourier $shippingcourier
     * @return Response
     */
    public function destroy(ShippingCourier $shippingcourier)
    {
        $this->shippingcourier->destroy($shippingcourier);

        return redirect()->route('admin.icommerce.shippingcourier.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::shippingcouriers.title.shippingcouriers')]));
    }
}
