<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\TaxRate;
use Modules\Icommerce\Http\Requests\CreateTaxRateRequest;
use Modules\Icommerce\Http\Requests\UpdateTaxRateRequest;
use Modules\Icommerce\Repositories\TaxRateRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TaxRateController extends AdminBaseController
{
    /**
     * @var TaxRateRepository
     */
    private $taxrate;

    public function __construct(TaxRateRepository $taxrate)
    {
        parent::__construct();

        $this->taxrate = $taxrate;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$taxrates = $this->taxrate->all();

        return view('icommerce::admin.taxrates.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.taxrates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTaxRateRequest $request
     * @return Response
     */
    public function store(CreateTaxRateRequest $request)
    {
        $this->taxrate->create($request->all());

        return redirect()->route('admin.icommerce.taxrate.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::taxrates.title.taxrates')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TaxRate $taxrate
     * @return Response
     */
    public function edit(TaxRate $taxrate)
    {
        return view('icommerce::admin.taxrates.edit', compact('taxrate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TaxRate $taxrate
     * @param  UpdateTaxRateRequest $request
     * @return Response
     */
    public function update(TaxRate $taxrate, UpdateTaxRateRequest $request)
    {
        $this->taxrate->update($taxrate, $request->all());

        return redirect()->route('admin.icommerce.taxrate.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::taxrates.title.taxrates')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  TaxRate $taxrate
     * @return Response
     */
    public function destroy(TaxRate $taxrate)
    {
        $this->taxrate->destroy($taxrate);

        return redirect()->route('admin.icommerce.taxrate.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::taxrates.title.taxrates')]));
    }
}
