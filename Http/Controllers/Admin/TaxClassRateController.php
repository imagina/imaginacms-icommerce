<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\TaxClassRate;
use Modules\Icommerce\Http\Requests\CreateTaxClassRateRequest;
use Modules\Icommerce\Http\Requests\UpdateTaxClassRateRequest;
use Modules\Icommerce\Repositories\TaxClassRateRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TaxClassRateController extends AdminBaseController
{
    /**
     * @var TaxClassRateRepository
     */
    private $taxclassrate;

    public function __construct(TaxClassRateRepository $taxclassrate)
    {
        parent::__construct();

        $this->taxclassrate = $taxclassrate;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$taxclassrates = $this->taxclassrate->all();

        return view('icommerce::admin.taxclassrates.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.taxclassrates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTaxClassRateRequest $request
     * @return Response
     */
    public function store(CreateTaxClassRateRequest $request)
    {
        $this->taxclassrate->create($request->all());

        return redirect()->route('admin.icommerce.taxclassrate.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::taxclassrates.title.taxclassrates')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TaxClassRate $taxclassrate
     * @return Response
     */
    public function edit(TaxClassRate $taxclassrate)
    {
        return view('icommerce::admin.taxclassrates.edit', compact('taxclassrate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TaxClassRate $taxclassrate
     * @param  UpdateTaxClassRateRequest $request
     * @return Response
     */
    public function update(TaxClassRate $taxclassrate, UpdateTaxClassRateRequest $request)
    {
        $this->taxclassrate->update($taxclassrate, $request->all());

        return redirect()->route('admin.icommerce.taxclassrate.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::taxclassrates.title.taxclassrates')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TaxClassRate $taxclassrate
     * @return Response
     */
    public function destroy(TaxClassRate $taxclassrate)
    {
        $this->taxclassrate->destroy($taxclassrate);

        return redirect()->route('admin.icommerce.taxclassrate.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::taxclassrates.title.taxclassrates')]));
    }
}
