<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\TaxClass;
use Modules\Icommerce\Http\Requests\CreateTaxClassRequest;
use Modules\Icommerce\Http\Requests\UpdateTaxClassRequest;
use Modules\Icommerce\Repositories\TaxClassRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TaxClassController extends AdminBaseController
{
    /**
     * @var TaxClassRepository
     */
    private $taxclass;

    public function __construct(TaxClassRepository $taxclass)
    {
        parent::__construct();

        $this->taxclass = $taxclass;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$taxclasses = $this->taxclass->all();

        return view('icommerce::admin.taxclasses.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.taxclasses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTaxClassRequest $request
     * @return Response
     */
    public function store(CreateTaxClassRequest $request)
    {
        $this->taxclass->create($request->all());

        return redirect()->route('admin.icommerce.taxclass.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::taxclasses.title.taxclasses')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TaxClass $taxclass
     * @return Response
     */
    public function edit(TaxClass $taxclass)
    {
        return view('icommerce::admin.taxclasses.edit', compact('taxclass'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TaxClass $taxclass
     * @param  UpdateTaxClassRequest $request
     * @return Response
     */
    public function update(TaxClass $taxclass, UpdateTaxClassRequest $request)
    {
        $this->taxclass->update($taxclass, $request->all());

        return redirect()->route('admin.icommerce.taxclass.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::taxclasses.title.taxclasses')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TaxClass $taxclass
     * @return Response
     */
    public function destroy(TaxClass $taxclass)
    {
        $this->taxclass->destroy($taxclass);

        return redirect()->route('admin.icommerce.taxclass.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::taxclasses.title.taxclasses')]));
    }
}
