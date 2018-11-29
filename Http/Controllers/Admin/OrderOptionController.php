<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\OrderOption;
use Modules\Icommerce\Http\Requests\CreateOrderOptionRequest;
use Modules\Icommerce\Http\Requests\UpdateOrderOptionRequest;
use Modules\Icommerce\Repositories\OrderOptionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class OrderOptionController extends AdminBaseController
{
    /**
     * @var OrderOptionRepository
     */
    private $orderoption;

    public function __construct(OrderOptionRepository $orderoption)
    {
        parent::__construct();

        $this->orderoption = $orderoption;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$orderoptions = $this->orderoption->all();

        return view('icommerce::admin.orderoptions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.orderoptions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrderOptionRequest $request
     * @return Response
     */
    public function store(CreateOrderOptionRequest $request)
    {
        $this->orderoption->create($request->all());

        return redirect()->route('admin.icommerce.orderoption.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::orderoptions.title.orderoptions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  OrderOption $orderoption
     * @return Response
     */
    public function edit(OrderOption $orderoption)
    {
        return view('icommerce::admin.orderoptions.edit', compact('orderoption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OrderOption $orderoption
     * @param  UpdateOrderOptionRequest $request
     * @return Response
     */
    public function update(OrderOption $orderoption, UpdateOrderOptionRequest $request)
    {
        $this->orderoption->update($orderoption, $request->all());

        return redirect()->route('admin.icommerce.orderoption.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::orderoptions.title.orderoptions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  OrderOption $orderoption
     * @return Response
     */
    public function destroy(OrderOption $orderoption)
    {
        $this->orderoption->destroy($orderoption);

        return redirect()->route('admin.icommerce.orderoption.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::orderoptions.title.orderoptions')]));
    }
}
