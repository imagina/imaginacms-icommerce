<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Order_Option;
use Modules\Icommerce\Http\Requests\CreateOrder_OptionRequest;
use Modules\Icommerce\Http\Requests\UpdateOrder_OptionRequest;
use Modules\Icommerce\Repositories\Order_OptionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class Order_OptionController extends AdminBaseController
{
    /**
     * @var Order_OptionRepository
     */
    private $order_option;

    public function __construct(Order_OptionRepository $order_option)
    {
        parent::__construct();

        $this->order_option = $order_option;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$order_option = $this->order_option->all();

        return view('icommerce::admin.order_option.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.order_option.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateOrder_OptionRequest $request
     * @return Response
     */
    public function store(CreateOrder_OptionRequest $request)
    {
        $this->order_option->create($request->all());

        return redirect()->route('admin.icommerce.order_option.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::order_option.title.order_option')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order_Option $order_option
     * @return Response
     */
    public function edit(Order_Option $order_option)
    {
        return view('icommerce::admin.order_option.edit', compact('order_option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Order_Option $order_option
     * @param  UpdateOrder_OptionRequest $request
     * @return Response
     */
    public function update(Order_Option $order_option, UpdateOrder_OptionRequest $request)
    {
        $this->order_option->update($order_option, $request->all());

        return redirect()->route('admin.icommerce.order_option.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::order_option.title.order_option')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order_Option $order_option
     * @return Response
     */
    public function destroy(Order_Option $order_option)
    {
        $this->order_option->destroy($order_option);

        return redirect()->route('admin.icommerce.order_option.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::order_option.title.order_option')]));
    }
}
