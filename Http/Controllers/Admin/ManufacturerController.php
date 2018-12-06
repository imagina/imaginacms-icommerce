<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Manufacturer;
use Modules\Icommerce\Http\Requests\ManufacturerRequest;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ManufacturerController extends AdminBaseController
{
    /**
     * @var ManufacturerRepository
     */
    private $manufacturer;

    public function __construct(ManufacturerRepository $manufacturer)
    {
        parent::__construct();

        $this->manufacturer = $manufacturer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$manufacturers = $this->manufacturer->all();

        return view('icommerce::admin.manufacturers.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.manufacturers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateManufacturerRequest $request
     * @return Response
     */
    public function store(ManufacturerRequest $request)
    {
        $this->manufacturer->create($request->all());

        return redirect()->route('admin.icommerce.manufacturer.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::manufacturers.title.manufacturers')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Manufacturer $manufacturer
     * @return Response
     */
    public function edit(Manufacturer $manufacturer)
    {
        return view('icommerce::admin.manufacturers.edit', compact('manufacturer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Manufacturer $manufacturer
     * @param  UpdateManufacturerRequest $request
     * @return Response
     */
    public function update(Manufacturer $manufacturer, ManufacturerRequest $request)
    {
        $this->manufacturer->update($manufacturer, $request->all());

        return redirect()->route('admin.icommerce.manufacturer.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::manufacturers.title.manufacturers')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Manufacturer $manufacturer
     * @return Response
     */
    public function destroy(Manufacturer $manufacturer)
    {
        $this->manufacturer->destroy($manufacturer);

        return redirect()->route('admin.icommerce.manufacturer.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::manufacturers.title.manufacturers')]));
    }
}
