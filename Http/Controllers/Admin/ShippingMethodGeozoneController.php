<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\ShippingMethodGeozone;
use Modules\Icommerce\Http\Requests\CreateShippingMethodGeozoneRequest;
use Modules\Icommerce\Http\Requests\UpdateShippingMethodGeozoneRequest;
use Modules\Icommerce\Repositories\ShippingMethodGeozoneRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ShippingMethodGeozoneController extends AdminBaseController
{
    /**
     * @var ShippingMethodGeozoneRepository
     */
    private $shippingmethodgeozone;

    public function __construct(ShippingMethodGeozoneRepository $shippingmethodgeozone)
    {
        parent::__construct();

        $this->shippingmethodgeozone = $shippingmethodgeozone;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$shippingmethodgeozones = $this->shippingmethodgeozone->all();

        return view('icommerce::admin.shippingmethodgeozones.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.shippingmethodgeozones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateShippingMethodGeozoneRequest $request
     * @return Response
     */
    public function store(CreateShippingMethodGeozoneRequest $request)
    {
        $this->shippingmethodgeozone->create($request->all());

        return redirect()->route('admin.icommerce.shippingmethodgeozone.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::shippingmethodgeozones.title.shippingmethodgeozones')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ShippingMethodGeozone $shippingmethodgeozone
     * @return Response
     */
    public function edit(ShippingMethodGeozone $shippingmethodgeozone)
    {
        return view('icommerce::admin.shippingmethodgeozones.edit', compact('shippingmethodgeozone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ShippingMethodGeozone $shippingmethodgeozone
     * @param  UpdateShippingMethodGeozoneRequest $request
     * @return Response
     */
    public function update(ShippingMethodGeozone $shippingmethodgeozone, UpdateShippingMethodGeozoneRequest $request)
    {
        $this->shippingmethodgeozone->update($shippingmethodgeozone, $request->all());

        return redirect()->route('admin.icommerce.shippingmethodgeozone.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::shippingmethodgeozones.title.shippingmethodgeozones')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ShippingMethodGeozone $shippingmethodgeozone
     * @return Response
     */
    public function destroy(ShippingMethodGeozone $shippingmethodgeozone)
    {
        $this->shippingmethodgeozone->destroy($shippingmethodgeozone);

        return redirect()->route('admin.icommerce.shippingmethodgeozone.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::shippingmethodgeozones.title.shippingmethodgeozones')]));
    }
}
