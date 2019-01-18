<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\ShippingMethod;
use Modules\Icommerce\Http\Requests\CreateShippingMethodRequest;
use Modules\Icommerce\Http\Requests\UpdateShippingMethodRequest;
use Modules\Icommerce\Repositories\ShippingMethodRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ShippingMethodController extends AdminBaseController
{
    /**
     * @var ShippingMethodRepository
     */
    private $shippingmethod;

    public function __construct(ShippingMethodRepository $shippingmethod)
    {
        parent::__construct();

        $this->shippingmethod = $shippingmethod;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $shippingMethods = $this->shippingmethod->all();
        return view('icommerce::admin.shippingmethods.index', compact('shippingMethods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.shippingmethods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateShippingMethodRequest $request
     * @return Response
     */
    public function store(CreateShippingMethodRequest $request)
    {
        $this->shippingmethod->create($request->all());

        return redirect()->route('admin.icommerce.shippingmethod.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::shippingmethods.title.shippingmethods')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ShippingMethod $shippingmethod
     * @return Response
     */
    public function edit(ShippingMethod $shippingmethod)
    {
        return view('icommerce::admin.shippingmethods.edit', compact('shippingmethod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ShippingMethod $shippingmethod
     * @param  UpdateShippingMethodRequest $request
     * @return Response
     */
    public function update(ShippingMethod $shippingmethod, UpdateShippingMethodRequest $request)
    {

        $this->shippingmethod->update($shippingmethod, $request->all());

        return redirect()->route('admin.icommerce.shippingmethod.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => $shippingmethod->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ShippingMethod $shippingmethod
     * @return Response
     */
    public function destroy(ShippingMethod $shippingmethod)
    {
        $this->shippingmethod->destroy($shippingmethod);

        return redirect()->route('admin.icommerce.shippingmethod.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::shippingmethods.title.shippingmethods')]));
    }
}
