<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\PriceList;
use Modules\Icommerce\Http\Requests\PriceListRequest;
use Modules\Icommerce\Http\Requests\UpdateListRequest;
use Modules\Icommerce\Repositories\ListRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PriceListController extends AdminBaseController
{
    /**
     * @var ListRepository
     */
    private $list;

    public function __construct(ListRepository $list)
    {
        parent::__construct();

        $this->list = $list;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$lists = $this->list->all();

        return view('icommerce::admin.lists.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.lists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PriceListRequest $request
     * @return Response
     */
    public function store(PriceListRequest $request)
    {
        $this->list->create($request->all());

        return redirect()->route('admin.icommerce.list.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::lists.title.lists')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  List $list
     * @return Response
     */
    public function edit(PriceList $list)
    {
        return view('icommerce::admin.lists.edit', compact('list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  List $list
     * @param  UpdateListRequest $request
     * @return Response
     */
    public function update(PriceList $list, UpdateListRequest $request)
    {
        $this->list->update($list, $request->all());

        return redirect()->route('admin.icommerce.list.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::lists.title.lists')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  List $list
     * @return Response
     */
    public function destroy(PriceList $list)
    {
        $this->list->destroy($list);

        return redirect()->route('admin.icommerce.list.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::lists.title.lists')]));
    }
}
