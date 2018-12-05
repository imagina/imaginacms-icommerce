<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\ItemType;
use Modules\Icommerce\Http\Requests\CreateItemTypeRequest;
use Modules\Icommerce\Http\Requests\UpdateItemTypeRequest;
use Modules\Icommerce\Repositories\ItemTypeRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ItemTypeController extends AdminBaseController
{
    /**
     * @var ItemTypeRepository
     */
    private $itemtype;

    public function __construct(ItemTypeRepository $itemtype)
    {
        parent::__construct();

        $this->itemtype = $itemtype;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$itemtypes = $this->itemtype->all();

        return view('icommerce::admin.itemtypes.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.itemtypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateItemTypeRequest $request
     * @return Response
     */
    public function store(CreateItemTypeRequest $request)
    {
        $this->itemtype->create($request->all());

        return redirect()->route('admin.icommerce.itemtype.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::itemtypes.title.itemtypes')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ItemType $itemtype
     * @return Response
     */
    public function edit(ItemType $itemtype)
    {
        return view('icommerce::admin.itemtypes.edit', compact('itemtype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ItemType $itemtype
     * @param  UpdateItemTypeRequest $request
     * @return Response
     */
    public function update(ItemType $itemtype, UpdateItemTypeRequest $request)
    {
        $this->itemtype->update($itemtype, $request->all());

        return redirect()->route('admin.icommerce.itemtype.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::itemtypes.title.itemtypes')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ItemType $itemtype
     * @return Response
     */
    public function destroy(ItemType $itemtype)
    {
        $this->itemtype->destroy($itemtype);

        return redirect()->route('admin.icommerce.itemtype.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::itemtypes.title.itemtypes')]));
    }
}
