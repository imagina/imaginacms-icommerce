<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Shipping;
use Modules\Icommerce\Http\Requests\CreateShippingRequest;
use Modules\Icommerce\Http\Requests\UpdateShippingRequest;
use Modules\Icommerce\Repositories\ShippingRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ShippingController extends AdminBaseController
{
    /**
     * @var ShippingRepository
     */
    private $shipping;

    public function __construct(ShippingRepository $shipping)
    {
        parent::__construct();

        $this->shipping = $shipping;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $shippingMethods = config('asgard.icommerce.config.shippingmethods');
        return view('icommerce::admin.shippings.index', compact('shippingMethods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.shippings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateShippingRequest $request
     * @return Response
     */
    public function store(CreateShippingRequest $request)
    {
        $this->shipping->create($request->all());

        return redirect()->route('admin.icommerce.shipping.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::shippings.title.shippings')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Shipping $shipping
     * @return Response
     */
    public function edit(Shipping $shipping)
    {
        return view('icommerce::admin.shippings.edit', compact('shipping'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Shipping $shipping
     * @param  UpdateShippingRequest $request
     * @return Response
     */
    public function update(Shipping $shipping, UpdateShippingRequest $request)
    {
        $this->shipping->update($shipping, $request->all());

        return redirect()->route('admin.icommerce.shipping.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::shippings.title.shippings')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Shipping $shipping
     * @return Response
     */
    public function destroy(Shipping $shipping)
    {
        $this->shipping->destroy($shipping);

        return redirect()->route('admin.icommerce.shipping.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::shippings.title.shippings')]));
    }
}
